function uploadImage()
{
    const uploadInput = document.getElementById("input-file");
    const imageContainer = document.getElementById("input-image-container"); 

    imageContainer.innerHTML = "";
    for (let i = 0; i < uploadInput.files.length; i++)
    {
        let image = document.createElement("img");
        image.classList.add("image-item");
        image.src = URL.createObjectURL(uploadInput.files[i]);
        // image.onload = function() { URL.revokeObjectURL(item.src); }; // free memory

        imageContainer.append(image); 
    }
}
