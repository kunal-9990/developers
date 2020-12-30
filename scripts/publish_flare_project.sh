# Adding a new help version:
#
# Place a folder named as the new version into the tmp directory as shown below.
# ----------------------------
# /docsmk2/
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

sudo chmod -R 777 .

echo "Backing up current content..."


echo 'Copying new content into place...'
mkdir -p public/documentation_files/$1/$2/$3/Content/$4
cp -R tmp/$3/* public/documentation_files/$1/$2/$3/Content/$4
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


prefix="\/documentation_files\/$1\/$2\/$3\/Content\/$4\/Content\/Resources\/"
prefix="$prefix"

# echo $prefix

echo 'Updating img src paths...'
#cd public/documentation_files/$1/$2/$3/Content/$4

find . -type f -print0 | xargs -0 sed -i 's/src="\/...\/...\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/..\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/..\/..\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="\/Resources/src="'"$prefix"'/g'
find . -type f -print0 | xargs -0 sed -i 's/href="..\/Resources/href="'"$prefix"'/g'

cd ../../../../../../..
#pwd
echo 'Copying Data folders into place...'

#end-user search results
mkdir -p public/search/$1/$2/$3/$4
cp -R tmp/$3/Data public/search/$1/$2/$3/$4
cd public/search/$1/$2/$3

cp -R en fr
cp -R en es
cp -R en cn
cp -R en de
# cp -R en nl

cd ../../../../..

#se-search results
mkdir -p public/se-search/$1/$2/$3/$4
cp -R tmp/$3/Data-SE public/se-search/$1/$2/$3/$4
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

# find . ! -name '*.sh' -type f -exec chmod 644 {} \;    
# find . ! -name 'scripts' -type d -exec chmod 755 {} \;
sudo chmod -R 777 . 

echo 'Done.'
