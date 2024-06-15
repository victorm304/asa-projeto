#!/bin/bash
/sbin/service named restart
/usr/sbin/rndc reload
(sleep 5; /opt/rh/httpd24/root/usr/sbin/apachectl restart)&
