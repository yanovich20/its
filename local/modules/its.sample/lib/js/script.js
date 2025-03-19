document.addEventListener(
    "DOMContentLoaded",
    function (event) {
        let titleDescriptionContainer = document.createElement("div");
        titleDescriptionContainer.classList.add("title-description-container");

        let labelTitle = document.createElement("div");
        labelTitle.classList.add("label");
        labelTitle.innerText = "введите заголовок";

        let inputTitle = document.createElement("input");
        inputTitle.setAttribute("id", "input-title");
        inputTitle.setAttribute("type", "text");
        inputTitle.setAttribute("name", "input-title");
        inputTitle.setAttribute("placeholder", "Введите заголовок");
        inputTitle.classList.add("content-input");

        let labelDescription = document.createElement("div");
        labelDescription.classList.add("label");
        labelDescription.innerText = "Введите описание";

        let inputDescription = document.createElement("input");
        inputDescription.setAttribute("id", "input-description");
        inputDescription.setAttribute("type", "text");
        inputDescription.setAttribute("name", "input-description");
        inputDescription.setAttribute("placeholder", "Введите описание");
        inputDescription.classList.add("content-input");

        let button = document.createElement("input");
        button.setAttribute("type", "button");
        button.setAttribute("value", "Отправить");
        button.setAttribute("id", "btn-send");
        button.addEventListener("click", function (event) {
            let description = document.querySelector("[name='input-description']").value;
            let title = document.querySelector("[name='input-title']").value;
            let url = window.location.pathname;
            let data = {
                "UF_TITLE": title,
                "UF_DESCRIPTION": description,
                "UF_URL": url
            }
            BX.ajax.runAction("its:sample.TitleAndDescriptionController.save", { data: data }).then(function (response) {
                showMessage(response.data.message);
                document.querySelector('meta[name="description"]').setAttribute("content", description);
                document.title = title;
                document.querySelector("#pagetitle").innerText = title;
            });
        });
        titleDescriptionContainer.append(labelTitle);
        titleDescriptionContainer.append(inputTitle);
        titleDescriptionContainer.append(labelDescription);
        titleDescriptionContainer.append(inputDescription);
        titleDescriptionContainer.append(button);

        let header = document.querySelector("#header");
        header.prepend(titleDescriptionContainer);
    });
function showMessage(message) {
    const messageBox = new BX.UI.Dialogs.MessageBox(
        {
            message: message,
            title: "Информационное сообщение",
            buttons: BX.UI.Dialogs.MessageBoxButtons.OK,
            okCaption: "OK",
        });
    messageBox.show();
}