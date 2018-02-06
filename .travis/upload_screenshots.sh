#!/bin/bash

TARGET_FOLDER="jasteuer@stl-s-stud.htwsaar.de:/export/home_16/jasteuer/public_html/sqe"
FINAL_BASE_LINK="http://www1.htwsaar.de/~jasteuer/sqe"
FINAL_TUNNEL_LINK="localhost:9000/~jasteuer/sqe"

for FILE in ../_screenshots/*; do 
    NAME=$(basename $FILE);
    echo "uploading screenshot to: $FINAL_BASE_LINK/$NAME"; 
    echo "                         $FINAL_TUNNEL_LINK/$NAME"; 
    scp -i id_rsa $FILE "$TARGET_FOLDER/$NAME" 
done
