#!/bin/bash

# What user is WP installed in?
USER=

# Setup
HOST=`echo $HOSTNAME | cut -d '.' -f 1`
PLUGIN_DATA_DIR=/home/"$USER"/public_html/wp-content/plugins/doooo-dashboard/data

# Clear out file and write php boilerplate
echo -n `cat $PLUGIN_DATA_DIR/last-logins-template.php` > $PLUGIN_DATA_DIR/last_logins.php

# Write report data
echo -n `cat /root/"$HOST"_last_logins.csv` >> $PLUGIN_DATA_DIR/last_logins.php

# Add final semicolon
echo "\';" >> $PLUGIN_DATA_DIR/last_logins.php

# Make sure report is readable by WP
chown $USER:$USER PLUGIN_DATA_DIR/last_logins.php
chmod 755 PLUGIN_DATA_DIR/last_logins.php
