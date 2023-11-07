const form = document.querySelector(".wrapper form");
const shortenBtn = form.querySelector("button");
const blurEffect = document.querySelector(".blur-effect");
const popup = document.querySelector(".popup-box");
const popupForm = popup.querySelector("form");
const shortURL = popup.querySelector("input");
const saveBtn = popupForm.querySelector("button");
const copyBtn = popup.querySelector(".copy-icon");

form.onsubmit = (evt) => {
    evt.preventDefault();
}
shortenBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/url-controls.php", true);
    xhr.onload = () => {
        if(xhr.readyState === 4 && xhr.status === 200) {
            let data = xhr.response;
            if (data.length <= 5) {
                blurEffect.style.display = "block";
                popup.classList.add("show");

                let domain = "http://urls/";
                shortURL.value = domain + data;
                copyBtn.onclick = () => {
                    shortURL.select();
                    document.execCommand('copy');
                }
                popupForm.onsubmit = (evt) => {
                    evt.preventDefault();
                }
                saveBtn.onclick = () => {
                    let xhr2 = new XMLHttpRequest();
                    xhr2.open("POST", "php/edit-url.php", true);
                    xhr2.onload = () => {
                        if(xhr2.readyState === 4 && xhr2.status === 200) {
                            let data = xhr2.response;
                            if (data === "success") {
                                location.reload();
                            } else {
                                alert(data);
                            }
                        }
                    }
                    let original_url = shortURL.value;
                    let gen_str = data;
                    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr2.send("original_url="+original_url+"&gen_str="+gen_str);
                }
            } else {
                alert(data);
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}