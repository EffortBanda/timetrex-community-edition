#!/bin/bash

#Unit testw with HHVM
#hhvm -c /etc/hhvm/server.hdf /usr/bin/phpunit --debug -vv --configuration config.xml


if [ "$#" -eq 0 ] ; then
	echo "Running tests in parallel..."
	# Retrieve and parse all groups, strip off the first 5 lines though due to PHPUnit  banner
	groups=$(phpunit -d max_execution_time=86400 --configuration config.xml --list-groups | tail -n +5)
	 
	parsed=$(echo $groups | sed "s/-/\t/g")
	results=$(echo $parsed | awk '{for(i=9;i<=NF;i++) {print $i}}')
 
	# Loop on each group name and run parallel. Run 2 more jobs than CPU cores, but don't go above a load of 8.
	echo "Start: `date`"
	for i in $results; do
	   echo $i
	done | parallel -P 200% --load 100% --halt-on-error 2 $0 -v --group {}
	if [ $? != 0 ] ; then
	        echo "UNIT TESTS FAILED...";
		echo "End: `date`"
	        exit 1;
	fi      
	echo "End: `date`"
elif [ "$1" == "-v" ] ; then
	#Being called from itself, use quiet mode.
	echo -n "Running: $@ :: ";
	phpunit -d max_execution_time=86400 --configuration config.xml $@ | tail -n 3 | tr -s "\n" | tr "\n" " "
	#Capture the exit status of PHPUNIT and make sure we return that. 
	exit_code=${PIPESTATUS[0]};
	echo ""
	exit $exit_code;
else
	phpunit -d max_execution_time=86400 --configuration config.xml $@ 
fi
