#!/bin/bash
set -x

#firewall-cmd --add-service=http

chmod 777 /var/www/kendo-server/admin
mkdir /var/www/kendo-server/admin/log
chmod -R 777 /var/www/kendo-server/admin/log
mkdir /var/www/kendo-server/admin/output/
chmod -R 777 /var/www/kendo-server/admin/output/
chmod -R 777 /var/www/kendo-server/admin/templates/
chmod 777 /var/www/kendo-server/result

chmod -R 777 /var/www/kendo-server/result/log

sudo setsebool -P httpd_can_network_connect 1
sudo semanage fcontext -a -t httpd_sys_rw_content_t /var/www/kendo-server/admin/log
sudo restorecon -v  /var/www/kendo-server/admin/log
sudo semanage fcontext -a -t httpd_sys_rw_content_t /var/www/kendo-server/admin/templates
sudo restorecon -v  /var/www/kendo-server/admin/templates/
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/kendo-server/admin/templates(/.*)?"
sudo restorecon -v  "/var/www/kendo-server/admin/templates(/.*)?"
sudo restorecon -v /var/www/kendo-server/admin/templates/templates/
sudo restorecon -v /var/www/kendo-server/admin/templates/templates_c/
sudo restorecon -v /var/www/kendo-server/admin/templates/excel

sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/kendo-server/result(/.*)?"
sudo restorecon -v /var/www/kendo-server/result
sudo restorecon -v /var/www/kendo-server/result/2026/
sudo restorecon -v /var/www/kendo-server/result/realtime/
sudo restorecon -v /var/www/kendo-server/result/log
sudo semanage fcontext -a -t httpd_sys_rw_content_t /var/www/kendo-server/result/kyoshokuin/2025
sudo restorecon -v /var/www/kendo-server/result/kanto/2026

sudo setsebool -P httpd_enable_cgi on

sudo chmod 777 /var/www/kendo-server/input/log
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/var/www/kendo-server/input/log(/.*)?"
sudo restorecon -v /var/www/kendo-server/input/log/
