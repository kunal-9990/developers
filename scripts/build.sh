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
dos2unix scripts/build.sh

# publish docs
# dos2unix /usr/share/nginx/developers/scripts/build.sh
echo 'Copying new content into place...'
mkdir -p public/documentation_files/$1/$2/
mkdir -p public/images/$1/$2/
mv public/documentation_files/$1/$2/* /tmp/old
cp -R tmp/$1/$2/* public/documentation_files/$1/$2/
cp -R tmp/$1/$2/Content/Resources/Images/* public/images/$1/$2
cp -R tmp/$1/$2/Content/Resources/I/* public/images/$1/$2
cd public/documentation_files/$1/$2/

find -name "*.fltoc" -print0 | xargs -0 sed -i "s/\/Content\//\/$1\/$2\//g"
echo "Copying over TOC and redirect xml files..."

for f in *.fltoc; do 
    mv -- "$f" "${f%.fltoc}.xml"
done

echo 'Renaming some files...'

echo 'Updating img src paths...'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/..\/Resources\/Images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/Resources\/Images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/Images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="\/Images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/images/src="\/images\/'"$1\/$2"'/g' 
find . -type f -print0 | xargs -0 sed -i 's/src="images/src="\/images\/'"$1\/$2"'/g'
find . -type f -print0 | xargs -0 sed -i 's/src="..\/Resources\/Icons/src="\/images\/'"$1\/$2"'/g'

# sudo find /usr/share/nginx/developers/public/documentation_files/$1/$2/ -mindepth 1 -type f -mmin +15 -delete

# echo 'Done.'
