#!/bin/bash

cd /var/www/html/seedb

# สำหรับโฟลเดอร์ hr
git checkout -b hr_branch
git add application/controllers/hr
git commit -m "Add hr folder"
git push origin hr_branch

# สำหรับโฟลเดอร์ que
git checkout -b que_branch
git add application/controllers/que
git commit -m "Add que folder"
git push origin que_branch

# สำหรับโฟลเดอร์ line
git checkout -b line_branch
git add application/controllers/line
git commit -m "Add line folder"
git push origin line_branch
