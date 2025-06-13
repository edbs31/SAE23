#!/usr/bin/env bash
# ------------------------------------------------------------
# mqtt2mysql.sh : récupère les données MQTT et les insère
# ------------------------------------------------------------

BROKER="mqtt.iut-blagnac.fr"
TOPIC="AM107/by-room/+/data"

# 4 salles à traiter
ROOMS=(B001 B101 E100 E105)

# Nom logique → libellé en base
declare -A SENSORS=(
  [temperature]="Température"
  [humidity]="Humidité"
  [co2]="CO2"
  [illumination]="Luminosité"
)

# Infos MySQL (talon d'Achille : on ne stocke pas de mot de passe en clair,
# mais c'est plus simple pour éviter l erreur /root/.my.cnf)
DB_USER="root"
DB_PASS=""
DB_NAME="sae23"
MYSQL_BIN="/opt/lampp/bin/mysql"

LOGFILE="/var/log/mqtt2mysql.log"
touch "$LOGFILE" && chmod 644 "$LOGFILE"

log() {
  echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" | tee -a "$LOGFILE"
}

insert_measure() {
  local room="$1"
  local label="$2"
  local value="$3"

  # Récupère l’ID du capteur
  local cap_id
  cap_id=$(
    "$MYSQL_BIN" -u"$DB_USER" -p"$DB_PASS" -D"$DB_NAME" \
      -sN -e \
      "SELECT id_capteur
       FROM Capteur
       WHERE salle_nom='${room}'
         AND type='${label}'
       LIMIT 1;"
  )

  if [[ -z "$cap_id" ]]; then
    log "⚠️ Aucun capteur trouvé pour ${label} dans salle ${room}"
    return
  fi

  # Insère la mesure
  "$MYSQL_BIN" -u"$DB_USER" -p"$DB_PASS" -D"$DB_NAME" <<SQL
INSERT INTO Mesure (valeur, date, heure, id_capteur)
VALUES (${value}, CURDATE(), CURTIME(), ${cap_id});
SQL

  if [[ $? -eq 0 ]]; then
    log "✔️ Mesure insérée : ${label}=${value} pour salle ${room}"
  else
    log "❌ Erreur d’insertion ${label} pour salle ${room}"
  fi
}

# Souscrit et boucle
mosquitto_sub -h "$BROKER" -t "$TOPIC" | while IFS= read -r payload; do
  log "🔷 Message MQTT reçu : $payload"

  # Vérifie que c'est du JSON
  if ! jq -e . >/dev/null 2>&1 <<<"$payload"; then
    log "❌ Payload non JSON, on passe"
    continue
  fi

  # Pour chaque salle définie
  for room in "${ROOMS[@]}"; do
    # On regarde si ce message contient exactement cette salle
    if ! jq -e --arg r "$room" '.[] | select(.room==$r)' <<<"$payload" >/dev/null; then
      continue
    fi

    # Pour chaque type de capteur
    for key in "${!SENSORS[@]}"; do
      val=$(jq -r --arg k "$key" --arg r "$room" \
        '.[] | select(.room==$r) | .[$k]' <<<"$payload")
      if [[ -n "$val" && "$val" != "null" ]]; then
        insert_measure "$room" "${SENSORS[$key]}" "$val"
      fi
    done
  done
done
