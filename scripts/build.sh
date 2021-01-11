# Adding a new help version:
#
# Place a folder named as the new version into the tmp directory as shown below.
# ----------------------------
# /docsm42/
# │
# └───/tmp/
# │   │  
# │   └───/30/
# │       │   
# │       └─── /Content/
# │       │    Online Output.fltoc
# │       │    csh_redirect.xml
#
# ----------------------------
#
# Run "npm run build" and supply the year, product, version, and language as parameters.
# Example:
# npm run build 2018 webapps 30 en
#
# wait until the script says "done." 
#dos2unix scripts/build.sh

# sudo chmod -R 777 /usr/share/nginx/docs

# echo "Backing up current content..."
# sudo mv public/documentation_files/$1/$2/$3/Content/$4 tmp/Content_backups/en_$(date -d "today" +"%Y%m%d%H%M")

dos2unix /usr/share/nginx/developers/scripts/build.sh
echo 'Copying new content into place...'
mkdir -p public/documentation_files/$1/$2/
cp -R tmp/$1/$2/* public/documentation_files/$1/$2/
cd public/documentation_files/$1/$2/

# sudo chmod -R 777 .

echo 'Renaming some files...'

find -name "*.fltoc" -print0 | xargs -0 sed -i 's/\/Content\//\//g'

#mv Online\ Output.fltoc OnlineOutput.xml
#mv Online\ Output\ \(SE\ Authoring\).fltoc SE-Authoring-TOC.xml 

echo "Copying over TOC and redirect xml files..."

file=./Online\ Output.fltoc
if [ -e "$file" ]; then
    mv Online\ Output.fltoc OnlineOutput.xml
else 
    echo "Online Output.fltoc was not included in upload"
fi 

file=./Online\ Output\ \(SE\ Authoring\).fltoc
if [ -e "$file" ]; then
    mv Online\ Output\ \(SE\ Authoring\).fltoc SE-Authoring-TOC.xml
else 
    echo "Online Output (SE Authoring).fltoc was not included in upload"
fi 

file=./csh_redirect.xml
if [ -e "$file" ]; then
    mv csh_redirect.xml ../..
    echo "Moving csh_redirect.xml..."
else 
    echo "csh_redirect.xml was not included in upload"
fi 


prefix="\/documentation_files\/$1\/$2\/Content/Resources\/"
prefix="$prefix"

# echo $prefix

echo 'Updating img src paths...'
#cd public/documentation_files/$1/$2/$3/Content/$4

find . -type f -print0 | xargs -0 sed -i 's/src="..\/Resources/src="\/Resources/g'

cd ../../../../../../..
#pwd
echo 'Copying Data folders into place...'

#end-user search results
# php artisan index


echo 'Setting File permissions...'

# find . ! -name '*.sh' -type f -exec chmod 644 {} \;    
# find . ! -name 'scripts' -type d -exec chmod 755 {} \;
# sudo find /usr/share/nginx/docs -type f -exec chmod 664 {} \;    
# sudo find /usr/share/nginx/docs -type d -exec chmod 775 {} \;
# pwd
# sudo chmod -R 777 storage
# sudo chmod -R 777 scripts
echo 'Done.'