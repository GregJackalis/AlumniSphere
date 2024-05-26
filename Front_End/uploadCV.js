function previewImage(event) {
    const profilePicture = document.getElementById('profilePicture');
    const file = event.target.files[0];
    const reader = new FileReader();
    
    reader.onload = function() {
        profilePicture.src = reader.result;
    }
    
    if (file) {
        reader.readAsDataURL(file);
    }
}