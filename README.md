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
   ./data/copy_reports.sh
   ```

4. Add it to cron and run daily
```bash
crontab -e
```

```
0 0 * * * /home/USERNAME/public_html/wp-content/plugins/dooo-dashboard/data/copy_reports.sh > /tmp/copy_reports.log
```
