module.exports = () => {
  
  var codeBlocks = document.querySelectorAll('pre:not(.noformat) code:not(.noformat)');

  function charParse(arr) {
      for(var i=0; i < arr.length; i++) {
          if (arr[i].length > 1 && arr[i].includes(' ')) {
              arr[i] = '\n' + arr[i];
          }
      }
      return arr.join('');
  }
  
  function charSplit(str) {
      for (var i=0, arr=[], l, j=-1; i<str.length; i++)
          l==(c = str.charAt(i)) ? arr[j] += (l=c) : arr[++j] = (l=c);
      return charParse(arr);
  }

  for (i = 0; i < codeBlocks.length; i++) {
    console.log("hello am i here?");

      var newNode = document.createElement('code');
      newNode.innerHTML = charSplit(codeBlocks[i].textContent);
      codeBlocks[i] = codeBlocks[i].replaceWith(newNode);
  }
};