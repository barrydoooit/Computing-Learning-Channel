function readURL(input, displayerID) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      console.log(e.target.result);
      var urlString = 'url('+ e.target.result + ')';
      document.getElementById(displayerID).style.backgroundImage = urlString;
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#imgInp").change(function () {
  readURL(this,'img-frame');
});
