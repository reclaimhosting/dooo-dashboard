## Setup notes:

1. `cd` to plugins directory of main DoOO WP site
    ```bash
    cd /home/USERNAME/public_html/wp-content/plugins
    ```

2. Clone this git repo
    ```bash
    git clone https://github.com/reclaimhosting/dooo-dashboard.git
    ```

3. Run the `copy_reports.sh` script at least once and activate the plugin in the WP Dashboard to test things are working
   ```bash
   ./copy_reports.sh
   ```

4. Add it to cron and run daily
    ```bash
    crontab -e
    ```

    Add this line, replacing USERNAME with the username of the cPanel account that has the DoOO WP front-end

    ```
    1 0 * * * /home/USERNAME/public_html/wp-content/plugins/dooo-dashboard/copy_reports.sh > /tmp/copy_reports.log
    ```

### If there are multiple WHM servers in their DoOO
Call the script with the other server names as arguments. Keypairs will need to be set up for stuff to copy between servers properly.

Ex:
```bash
bash copy_reports.sh stateu2 stateu3 stateu4
```

or in the cron:
```bash
1 0 * * * /home/USERNAME/public_html/wp-content/plugins/dooo-dashboard/copy_reports.sh stateu2 stateu3 stateu4 > /tmp/copy_reports.log
```