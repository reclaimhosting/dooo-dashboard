#!/bin/bash

# Setup
SCRIPT_DIR=`cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd`
USER=`echo $SCRIPT_DIR | cut -d '/' -f 3`
HOST=`echo $HOSTNAME | cut -d '.' -f 1`

# Clear out file and write php boilerplate
cat $SCRIPT_DIR/template.php > $SCRIPT_DIR/last-logins.php
echo '$bar = \'LAST LOGIN DATE, USERNAME, EMAIL, PRIMARY DOMAIN, DISK USAGE, START DATE' >> $SCRIPT_DIR/last-logins.php

# Write report data
cat /root/"$HOST"_last_logins.csv >> $SCRIPT_DIR/last-logins.php

# Add final semicolon
echo "';" >> $SCRIPT_DIR/last-logins.php

# Make sure reports are readable by WP
chown $USER:$USER $SCRIPT_DIR/*.php
chmod 755 $SCRIPT_DIR/*.php