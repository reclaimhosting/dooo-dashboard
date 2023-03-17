#!/bin/bash

# Setup
SCRIPT_DIR=`cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd`
USER=`echo $SCRIPT_DIR | cut -d '/' -f 3`
HOST=`echo $HOSTNAME | cut -d '.' -f 1`

# Clear out file and write php boilerplate
echo -n `cat $SCRIPT_DIR/template.php` > $SCRIPT_DIR/last_logins.php
echo -n "$bar = \'LAST LOGIN DATE, USERNAME, EMAIL, PRIMARY DOMAIN, DISK USAGE, START DATE" > $PLUGIN_DATA_DIR/last_logins.php

# Write report data
echo -n `cat /root/"$HOST"_last_logins.csv` >> $SCRIPT_DIR/last_logins.php

# Add final semicolon
echo "';" >> $SCRIPT_DIR/last_logins.php

# Make sure report is readable by WP
chown $USER:$USER $SCRIPT_DIR/last_logins.php
chmod 755 $SCRIPT_DIR/last_logins.php
