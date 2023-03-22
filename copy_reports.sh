#!/bin/bash

# Setup
SCRIPT_DIR=`cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd`
USER=`echo $SCRIPT_DIR | cut -d '/' -f 3`
HOST=`echo $HOSTNAME | cut -d '.' -f 1`

# Clear out file and write php boilerplate
cat $SCRIPT_DIR/template.txt > $SCRIPT_DIR/data/last-logins.php

# Write report data
cat /root/"$HOST"_last_logins.csv >> $SCRIPT_DIR/data/last-logins.php

# Get reports from other servers
# Pass them as arguments when calling the script ex: `bash copy_reports.sh stateu2 stateu3 stateu4`
# Make sure ssh keypairs are setup so this actually works without having to type passwords
# Also make sure to run this at least once to accept host keys
for OTHER_HOST in "$@"
do
scp root@"$OTHER_HOST".reclaimhosting.com:/root/"$OTHER_HOST"_last_logins.csv /root/"$OTHER_HOST"_last_logins.csv
tail -n+2 /root/"$OTHER_HOST"_last_logins.csv >> $SCRIPT_DIR/data/last-logins.php
done

# Add final semicolon
echo "';" >> $SCRIPT_DIR/data/last-logins.php

# Make sure reports are readable by WP
chown $USER:$USER $SCRIPT_DIR/data/*.php
chmod 755 $SCRIPT_DIR/data/*.php