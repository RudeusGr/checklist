function cleanTable() {
    document.getElementById('custom-table-body').innerHTML = "";
}

function getAllReviewData() {
    fetch('http://192.168.1.12/corona/api/review/datareviews')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Ocurrio un error al cargar los datos',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            } else {
                data.forEach(element => {
                    document.getElementById('custom-table-body').innerHTML += `
                    <div class="custom-table-row">
                        <div class="labels">
                            <label>${element['folio']}</label>
                        </div>
                        <div class="labels">
                            <label>${element['id_user']}</label>
                        </div>
                        <div class="labels">
                            <label>${element['route']}</label>
                        </div>
                        <div class="labels">
                            <label>${element['date_review']}</label>
                        </div>
                        <div class="labels actions">
                            <div>
                                <input type="button" class="hidden-n-mobile" value="Revisión" onclick="window.open('http://192.168.1.12/corona/api/review/pdfreview/${element['id']}')" />
                                <img role="button" class="visible-n-mobile icon" src="src/public/icon/pdf.svg" onclick="window.open('http://192.168.1.12/corona/api/review/pdfreview/${element['id']}')" alt="PDF Icon">
                            </div>
                            <div>
                                <input type="button" class="hidden-n-mobile" value="Correo" onclick="sendMail(${element['id']})" />
                                <img role="button" class="visible-n-mobile icon" src="src/public/icon/mail.svg" onclick="sendMail(${element['id']})" alt="Mail Icon">
                            </div>
                            <div>
                                <input type="button" class="hidden-n-mobile" value="Cargo" onclick="sendMailCash(${element['id']})" />
                                <img role="button" class="visible-n-mobile icon" src="src/public/icon/cash.svg" onclick="sendMailCash(${element['id']})" alt="Cash Icon">
                            </div>
                        </div>
                    </div>
                    `;
                });
            }
        });
}

function getReviewsByDate() {
    let date = document.getElementById('dateFilter').value;

    if (date == '') {
        Swal.fire({
            title: 'Favor de verificar!',
            text: 'No se ha seleccionado una fecha para filtrar',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
    } else {
        cleanTable();
        fetch('http://192.168.1.12/corona/api/review/datareviewsbydate/' + date)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Ocurrio un error al cargar los datos',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                } else {
                    if (data.length == 0) {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'No existen revisiones para esta fecha',
                            icon: 'info',
                            confirmButtonText: 'Ok'
                        })
                    }
                    data.forEach(element => {
                        document.getElementById('custom-table-body').innerHTML += `
                        <div class="custom-table-row">
                            <div class="labels">
                                <label>${element['folio']}</label>
                            </div>
                            <div class="labels">
                                <label>${element['id_user']}</label>
                            </div>
                            <div class="labels">
                                <label>${element['route']}</label>
                            </div>
                            <div class="labels">
                                <label>${element['date_review']}</label>
                            </div>
                            <div class="labels actions">
                                <div>
                                    <input type="button" class="hidden-n-mobile" value="Revisión" onclick="window.open('http://192.168.1.12/corona/api/review/pdfreview/${element['id']}')" />
                                    <img role="button" class="visible-n-mobile icon" src="src/public/icon/pdf.svg" onclick="window.open('http://192.168.1.12/corona/api/review/pdfreview/${element['id']}')" class="visible-n-mobile icon" alt="PDF Icon">
                                </div>
                                <div>
                                    <input type="button" class="hidden-n-mobile" value="Correo" onclick="sendMail(${element['id']})" />
                                    <img role="button" class="visible-n-mobile icon" src="src/public/icon/mail.svg" onclick="sendMail(${element['id']})" alt="Mail Icon">
                                </div>
                                <div>
                                    <input type="button" class="hidden-n-mobile" value="Cargo" onclick="window.open('http://192.168.1.12/corona/api/review/pdfinvoice/${element['id']}')" />
                                    <img role="button" class="visible-n-mobile icon" src="src/public/icon/cash.svg" onclick="window.open('http://192.168.1.12/corona/api/review/pdfinvoice/${element['id']}')" alt="Cash Icon">
                                </div>
                            </div>
                        </div>
                    `;
                    });
                }
            });
    }
}

function sendMail(id) {
    fetch('http://192.168.1.12/corona/api/review/sendmail/' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                Swal.fire({
                    title: 'Envio fallido!',
                    text: 'Ocurrio un error al enviar la revisión por correo',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            } else {
                Swal.fire({
                    title: 'Envio correcto!',
                    text: 'Envio realizado correctamente',
                    icon: 'info',
                    confirmButtonText: 'Ok'
                })
            }
        });
}

document.getElementById("buttonFilter").addEventListener("click", (evt) => {
    evt.preventDefault();
    getReviewsByDate();
});

function sendMailCash(id) {
    fetch('http://192.168.1.12/corona/api/review/pdfinvoice/' + id)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                Swal.fire({
                    title: 'Envio fallido!',
                    text: 'Ocurrio un error al enviar el ticket de cobro por correo',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            } else {
                Swal.fire({
                    title: 'Envio correcto!',
                    text: 'Envío realizado correctamente',
                    icon: 'info',
                    confirmButtonText: 'Ok'
                })
            }
        });
}
