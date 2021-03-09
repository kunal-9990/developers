# Adding a new help version:
#
# Place a folder named as the new version into the tmp directory as shown below.
# ----------------------------
# /Developers/
# │
# └───/tmp/
# │   │  
# │   └───/Sherlock/
# │       │  
# │       └─── /v1/
# │            │  
# │            └─── /Content/
#
# ----------------------------
#
# Run "npm run build" and supply the year, product, version, and language as parameters.
# Example:
# npm run build 2018 webapps 30 en
#
# wait until the script says "done." 
#dos2unix scripts/build.sh


<<<<<<< HEAD
if [ -e "tmp/$1/$2/Project/TOCs/TOC.fltoc" ]; then
    sudo cp tmp/$1/$2/Project/TOCs/TOC.fltoc tmp/$1/$2/OnlineOutput.xml
    find tmp/$1/$2 -name "OnlineOutput.xml" -print0 | xargs -0 sed -i "s/\/Content\//\/$1\/$2\//g"
    
=======
echo "Backing up current content..."
sudo mv public/documentation_files/$1/$2/$3/Content/$4 tmp/Content_backups/en_$(date -d "today" +"%Y%m%d%H%M")


echo 'Copying new content into place...'
mkdir -p public/documentation_files/$1/$2/$3/Content/$4
cp -R tmp/$4/$3/* public/documentation_files/$1/$2/$3/Content/$4
cd public/documentation_files/$1/$2/$3/Content/$4

sudo chmod -R 777 .

echo 'Renaming some files...'

find -name "*.fltoc" -print0 | xargs -0 sed -i 's/\/Content//g'

#mv Online\ Output.fltoc OnlineOutput.xml
#mv Online\ Output\ \(SE\ Authoring\).fltoc SE-Authoring-TOC.xml

echo "Copying over TOC and redirect xml files..."

file=./Online\ Output.fltoc
if [ -e "$file" ]; then
    mv Online\ Output.fltoc OnlineOutput.xml
>>>>>>> a3cea90447d3bfff8634f705f47976825b735548
else 
    echo "Online Output.fltoc was not included in upload"
fi 



# publish docs
# dos2unix /usr/share/nginx/developers/scripts/build.sh
echo 'Copying new content into place...'
mkdir -p public/documentation_files/$1/$2/
mkdir -p public/images/$1/$2/
cp -R tmp/$1/$2/* public/documentation_files/$1/$2/
cp -R tmp/$1/$2/Content/Resources/Images/* public/images/$1/$2
cd public/documentation_files/$1/$2/


echo 'Renaming some files...'

echo 'Updating img src paths...'
<<<<<<< HEAD
find . -type f -print0 | xargs -0 sed -i 's/src="..\/..\/Resources\/Images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/Resources\/Images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/Images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="\/Images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/images/src="\/images\/'"$1\/$2"'/g'
=======
#cd public/documentation_files/$1/$2/$3/Content/$4

find . -type f -print0 | xargs -0 sed -i 's/src="\/...\/...\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/..\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/..\/..\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="\/Resources/src="'"$prefix"'/g'

cd ../../../../../../..
#pwd
echo 'Copying Data folders into place...'

#end-user search results
mkdir -p public/search/$1/$2/$3/$4
cp -R tmp/$4/$3/Data public/search/$1/$2/$3/$4
cd public/search/$1/$2/$3

cp -R en fr
cp -R en es
cp -R en cn
cp -R en de
# cp -R en nl

cd ../../../../..

#se-search results
mkdir -p public/se-search/$1/$2/$3/$4
cp -R tmp/$4/$3/Data-SE public/se-search/$1/$2/$3/$4
cd public/se-search/$1/$2/$3/$4
rm -R Data
mv Data-SE Data
cd ..

if [ $4 = "en" ]; then
    cp -R en fr
    cp -R en es
    cp -R en cn
    cp -R en de
else
  cp -R en nl
fi

# cp -R en fr
# cp -R en es
# cp -R en cn
# cp -R en de
# cp -R en nl

cd ../../../..


echo 'Setting File permissions...'
>>>>>>> a3cea90447d3bfff8634f705f47976825b735548


# echo 'Done.'
