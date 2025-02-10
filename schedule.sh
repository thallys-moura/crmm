#!/bin/bash
while true; do
	php artisan schedule:run >> storage/logs/schedule.log 2>&1
	sleep 60
done
