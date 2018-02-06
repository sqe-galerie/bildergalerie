#!/bin/bash 
cd $( cd "$(dirname "${BASH_SOURCE[0]}")" ; pwd -P )

TARGET_FOLDER="jasteuer@stl-s-stud.htwsaar.de:/export/home_16/jasteuer/public_html/sqe"
FINAL_BASE_LINK="http://www1.htwsaar.de/~jasteuer/sqe"
FINAL_TUNNEL_LINK="localhost:9000/~jasteuer/sqe"
 
if [ -d "../screenshots" ]; then
    for FILE in ../screenshots/*; do 
        if [ -f "$FILE" ]; then
            NAME=$(basename $FILE);
            echo "uploading screenshot to: $FINAL_BASE_LINK/$NAME"; 
            echo "                         $FINAL_TUNNEL_LINK/$NAME"; 
            scp -i id_rsa -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no $FILE "$TARGET_FOLDER/$NAME" 
        fi
    done
fi
