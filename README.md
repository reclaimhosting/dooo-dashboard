## Setup notes:

First find the username of the cPanel account that hosts their front-end WP site.

`cd` to plugins directory of the main DoOO WP site
```bash
cd /home/USERNAME/public_html/wp-content/plugins
```

Clone this git repo
```bash
git clone https://github.com/reclaimhosting/dooo-dashboard.git
```

Add it to cron to run daily
```bash
crontab -e
```

Add this line, replacing USERNAME with the username of the cPanel account that has the DoOO WP front-end
```bash
1 0 * * * /home/USERNAME/public_html/wp-content/plugins/dooo-dashboard/copy_reports.sh > /tmp/copy_reports.cron 2>&1
```

Test your cron entry by copying the whole line, removing the leading timing info, and running the command:
```bash
/home/USERNAME/public_html/wp-content/plugins/dooo-dashboard/copy_reports.sh > /tmp/copy_reports.cron 2>&1
```

Then activate the plugin in WP and make sure things are working.

### If there are multiple WHM servers in their DoOO

Call the script with the other server names as arguments. Keypairs and ssh config will need to be set up for stuff to copy between servers properly. Usually this involves making sure a keypair is generated on the main server with the WP site where the cron job will run, other servers have the public key, and the ssh config on the main server has been updated. 

Ex:
```bash
bash copy_reports.sh stateu2 stateu3 stateu4
```

or in the cron:
```bash
1 0 * * * /home/USERNAME/public_html/wp-content/plugins/dooo-dashboard/copy_reports.sh stateu2 stateu3 stateu4 > /tmp/copy_reports.cron 2>&1
```
