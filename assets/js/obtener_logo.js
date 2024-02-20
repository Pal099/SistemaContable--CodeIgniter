function getImageDataURL() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: logoDataURL,
            method: 'GET',
            success: function (dataURL) {
                resolve(dataURL);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}