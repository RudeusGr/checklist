let returnBottles = {};
let missingBottles = {};
let returnProducts = {};
let shelter = {};
let products = {};

function setDate() {
    let dateNow = new Date();
    document.getElementById('date').value = dateNow.toLocaleString().substring(0,17);
    setInterval(setDate, 60000);
}

function getAllDashboardData() {
    fetch('http://192.168.1.12/corona/api/dashboard/dataroutesreviewproduct')
        .then(response => response.json())
        .then(data => { console.log();
            document.getElementById('folio').value = data['review'];
            data['routes'].forEach(element => {
                document.getElementById('route').innerHTML += `<option value="${element.id}" id="${element.operador}">${element.name}</option>`;
            });
            data['stores'].forEach(element => {
                document.getElementById('selectCodeStore').innerHTML += `<option value="${element.id}" id="${element.name}">${element.code}</option>`;
            });
            products = data['products'];
            data['products'].forEach(element => {
                if (element.type == 'FULL') {
                    document.getElementById('selectReturnProduct').innerHTML += `<option value="${element.id}">${element.sku + ' ' + element.name}</option>`;
                }
                if (element.type == 'EMPTY') {
                    document.getElementById('selectReturnBottle').innerHTML += `<option value="${element.id}">${element.sku + ' ' + element.name}</option>`;
                    document.getElementById('selectMissingBottle').innerHTML += `<option value="${element.id}">${element.sku + ' ' + element.name}</option>`;
                    document.getElementById('selectShelterBottle').innerHTML += `<option value="${element.id}">${element.sku + ' ' + element.name}</option>`;
                }
            });
        });
}

document.getElementById('route').addEventListener('change', (env) => {
    document.getElementById('operador').value = document.getElementById('route')[document.getElementById('route').selectedIndex].id;
});

document.getElementById('selectCodeStore').addEventListener('change', (env) => {
    document.getElementById('storeName').value = document.getElementById('selectCodeStore')[document.getElementById('selectCodeStore').selectedIndex].id;
});

function validateReview() {
    let route = document.getElementById('route').value;
    let observation = document.getElementById('observation').value;

<<<<<<< HEAD
    if (Object.keys(returnBottles).length == 0 && Object.keys(returnProducts).length == 0) {
        Swal.fire({
            title: 'Advertencia!',
            text: 'Falta información de envases',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
=======
    if (Object.keys(returnBottles).length == 0 && Object.keys(returnProducts).length == 0 && Object.keys(missingBottles).length == 0) {
        alert('Faltan informacion de los envases');
>>>>>>> 6625145e0d6c2ef775b1c58baa6cf7da67d4d8ef
        return false;
    }

    if (route == '' || observation == '' || lineas.length == 0) {
        Swal.fire({
            title: 'Advertencia!',
            text: 'Falta información de la revision',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
        return false;
    }

    return true;
}

function cleanData() {
    borrandoCanvas();
    document.getElementById('observation').value = '';
    returnBottles = {};
    returnProducts = {};
    missingBottles = {};
    document.getElementById('table-return-bottle').innerHTML = '';
    document.getElementById('table-missing-bottle').innerHTML = '';
    document.getElementById('table-return-product').innerHTML = '';
    document.getElementById('table-shelter-bottle').innerHTML = '';

    document.getElementById('selectReturnBottle').value = '';
    document.getElementById('selectMissingBottle').value = '';
    document.getElementById('selectReturnProduct').value = '';
    document.getElementById('selectCodeStore').value = '';
    document.getElementById('selectShelterBottle').value = '';

    document.getElementById('inputReturnBottle').value = '';
    document.getElementById('inputMissingBottle').value = '';
    document.getElementById('inputReturnProduct').value = '';
    document.getElementById('inputShelterBottle').value = '';

    document.getElementById('storeName').value = '';
    document.getElementById('route').value = '';
    document.getElementById('operador').value = '';

}

document.getElementById('save').addEventListener('click', (env) => {
    if (validateReview()) {
        data = {
            route: document.getElementById('route').value,
            observation: document.getElementById('observation').value,
            signature: document.getElementById("pizarra").toDataURL(),
            return_bottles: returnBottles,
            return_products: returnProducts,
            missing_bottles: missingBottles,
            shelters: shelter
        }

        fetch('http://192.168.1.12/corona/api/dashboard/save', {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((res) => res.json())
            .then(data => {
                if (data.error) {
                    borrandoCanvas();
                    Swal.fire({
                        title: 'Advertencia!',
                        text: 'No se puede guardar revisión, falta información',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                } else {
                    cleanData();
                    escribiendoEnCanvas();
                    getAllDashboardData();
                    Swal.fire({
                        title: 'Perfecto!',
                        text: 'Revisión guardada exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                }
            })
    }
});


/***************** Buttoms add ********************/

document.getElementById('buttonReturnBottle').addEventListener('click', (env) => {
<<<<<<< HEAD
    if (document.getElementById('selectReturnBottle').options[document.getElementById('selectReturnBottle').selectedIndex].text == '' || document.getElementById('inputReturnBottle').value <= 0) {
        Swal.fire({
            title: 'No se pudo agregar envase!',
            text: 'Campo vacío o información incorrecta',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
    } else {
        returnBottles[document.getElementById('selectReturnBottle').value] = document.getElementById('inputReturnBottle').value;
        document.getElementById('table-return-bottle').innerHTML += `
                                                <div class="custom-table-row">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                ${document.getElementById('selectReturnBottle').options[document.getElementById('selectReturnBottle').selectedIndex].text}
                                                            </td>
                                                            <td>
                                                                ${document.getElementById('inputReturnBottle').value}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                `;
        document.getElementById('selectReturnBottle').value = '';
=======
    if (document.getElementById('inputReturnBottle').value == '' || document.getElementById('inputReturnBottle').value == 0) {
        alert('No a ingresado una cantidad de envases');
    } else {
        returnBottles[document.getElementById('selectReturnBottle').value] = document.getElementById('inputReturnBottle').value;
        document.getElementById('table-return-bottle').innerHTML += `
                                                    <div class="custom-table-row">
    
                                                        <div class="custom-table-cell flex-basis-70">
                                                            <span class="mobile-column-name">
                                                                Envase
                                                            </span>
                                                            <div class="center-wrapper">
                                                                <p>${document.getElementById('selectReturnBottle').options[document.getElementById('selectReturnBottle').selectedIndex].text}</p>
                                                            </div>
                                                        </div>
    
                                                        <div class="custom-table-cell flex-basis-30">
                                                            <span class="mobile-column-name">
                                                                Cantidad
                                                            </span>
                                                            <div class="center-wrapper">
                                                                <p>${document.getElementById('inputReturnBottle').value}</p>
                                                            </div>
                                                        </div>
    
                                                    </div>
                                                `;
>>>>>>> 6625145e0d6c2ef775b1c58baa6cf7da67d4d8ef
        document.getElementById('inputReturnBottle').value = '';
    }
});

document.getElementById('buttonMissingBottle').addEventListener('click', (env) => {
<<<<<<< HEAD
    if (document.getElementById('selectMissingBottle').options[document.getElementById('selectMissingBottle').selectedIndex].text == '' || document.getElementById('inputMissingBottle').value <= 0) {
        Swal.fire({
            title: 'No se pudo agregar envase!',
            text: 'Campo vacío o información incorrecta',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
=======
    if (document.getElementById('inputMissingBottle').value == '' || document.getElementById('inputMissingBottle').value == 0) {
        alert('No a ingresado una cantidad de envases');
>>>>>>> 6625145e0d6c2ef775b1c58baa6cf7da67d4d8ef
    } else {
        missingBottles[document.getElementById('selectMissingBottle').value] = document.getElementById('inputMissingBottle').value;
        document.getElementById('table-missing-bottle').innerHTML += `
                                                <div class="custom-table-row">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                ${document.getElementById('selectMissingBottle').options[document.getElementById('selectMissingBottle').selectedIndex].text}
                                                            </td>
                                                            <td>
                                                                ${document.getElementById('inputMissingBottle').value}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            `;
<<<<<<< HEAD
        document.getElementById('selectMissingBottle').value = '';
=======
>>>>>>> 6625145e0d6c2ef775b1c58baa6cf7da67d4d8ef
        document.getElementById('inputMissingBottle').value = '';
    }
});

document.getElementById('buttonReturnProduct').addEventListener('click', (env) => {
<<<<<<< HEAD
    if (document.getElementById('selectReturnProduct').options[document.getElementById('selectReturnProduct').selectedIndex].text == '' || document.getElementById('inputReturnProduct').value <= 0) {
        Swal.fire({
            title: 'No se pudo agregar producto!',
            text: 'Campo vacío o información incorrecta',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
=======
    if (document.getElementById('inputReturnProduct').value == '' || document.getElementById('inputReturnProduct').value == 0) {
        alert('No a ingresado una cantidad a devolver');
>>>>>>> 6625145e0d6c2ef775b1c58baa6cf7da67d4d8ef
    } else {
        returnProducts[document.getElementById('selectReturnProduct').value] = document.getElementById('inputReturnProduct').value;
        document.getElementById('table-return-product').innerHTML += `
                                                <div class="custom-table-row">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                ${document.getElementById('selectReturnProduct').options[document.getElementById('selectReturnProduct').selectedIndex].text}
                                                            </td>
                                                            <td>
                                                                ${document.getElementById('inputReturnProduct').value}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
<<<<<<< HEAD
                                                `;
        document.getElementById('selectReturnProduct').value = '';
=======
                                            `;
>>>>>>> 6625145e0d6c2ef775b1c58baa6cf7da67d4d8ef
        document.getElementById('inputReturnProduct').value = '';
    }
});

document.getElementById('buttonShelterBottle').addEventListener('click', (env) => {
    if (document.getElementById('selectShelterBottle').options[document.getElementById('selectShelterBottle').selectedIndex].text == '' || document.getElementById('selectCodeStore').value == '' || document.getElementById('inputShelterBottle').value <= 0) {
        Swal.fire({
            title: 'No se pudo agregar producto!',
            text: 'Campo vacío o información incorrecta',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
    } else {
        shelter[Object.keys(shelter).length] = [document.getElementById('selectCodeStore').value, document.getElementById('selectShelterBottle').value, document.getElementById('inputShelterBottle').value];
        document.getElementById('table-shelter-bottle').innerHTML += `
                                                <div class="custom-table-row">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                ${document.getElementById('selectCodeStore').options[document.getElementById('selectCodeStore').selectedIndex].text}
                                                            </td>
                                                            <td>
                                                                ${document.getElementById('selectShelterBottle').options[document.getElementById('selectShelterBottle').selectedIndex].text}
                                                            </td>
                                                            <td>
                                                                ${document.getElementById('inputShelterBottle').value}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                `;
        document.getElementById('selectCodeStore').value = '';
        document.getElementById('storeName').value = '';
        document.getElementById('selectShelterBottle').value = '';
        document.getElementById('inputShelterBottle').value = '';
    }
});


/******************* CANVAS **********************/
let miCanvas = document.getElementById('pizarra');
let ctx = miCanvas.getContext("2d");
ctx.strokeStyle = "#232";
let pintarLinea = false;
let m = { x: 0, y: 0 };
let lineas = [];
let nuevaPosicionX = 0;
let nuevaPosicionY = 0;
miCanvas.height = 150;
miCanvas.width = 250;
let cw = (miCanvas.width), cx = cw / 2;
let ch = (miCanvas.height), cy = ch / 2;

var eventsArray = [{ event: "mousedown", func: "empezandoDibujo" },
{ event: "touchstart", func: "empezandoDibujo" },
{ event: "mousemove", func: "dibujandoLinea" },
{ event: "touchmove", func: "dibujandoLinea" },
{ event: "mouseup", func: "terminandoDibujo" },
{ event: "touchend", func: "terminandoDibujo" },
{ event: "mouseout", func: "terminandoDibujo" }
];


if (miCanvas) {
    escribiendoEnCanvas();
}

function escribiendoEnCanvas() {
    var x = miCanvas.width / 2;
    var y = miCanvas.height / 1.65;
    ctx.textAlign = "center";
    ctx.font = "30pt Inter-Regular, sans-serif";
    ctx.fillStyle = "#23232333";
    ctx.fillText("Firma", x, y);
}

function empezandoDibujo(evt) {
    m = oMousePos(miCanvas, evt);
    ctx.beginPath();
    pintarLinea = true;

    lineas.push([]);
}

function guardandoLinea() {
    lineas[lineas.length - 1].push({
        x: nuevaPosicionX,
        y: nuevaPosicionY
    });
}

function dibujandoLinea(evt) {
    if (pintarLinea) {
        ctx.moveTo(m.x, m.y);
        m = oMousePos(miCanvas, evt);
        ctx.lineTo(m.x, m.y);
        ctx.stroke();

        // Guarda la linea
        guardandoLinea();
        // Redibuja todas las lineas guardadas
        ctx.beginPath();
        lineas.forEach(function (segmento) {
            ctx.moveTo(segmento[0].x, segmento[0].y);
            segmento.forEach(function (punto, index) {
                ctx.lineTo(punto.x, punto.y);
            });
        });
        ctx.stroke();
    }
}

function terminandoDibujo(evt) {
    pintarLinea = false;

    guardandoLinea();
}

function oMousePos(canvas, evt) {
    var ClientRect = miCanvas.getBoundingClientRect();
    var e = evt.touches ? evt.touches[0] : evt;

    return {
        x: Math.round(e.clientX - ClientRect.left),
        y: Math.round(e.clientY - ClientRect.top)
    };
}

for (var i = 0; i < eventsArray.length; i++) {
    (function (i) {
        var e = eventsArray[i].event;
        var f = eventsArray[i].func; console.log(f);
        miCanvas.addEventListener(e, function (evt) {
            evt.preventDefault()
            window[f](evt);
            return;
        }, false);
    })(i);
}

function borrandoCanvas() {
    lineas = [];
    ctx.clearRect(0, 0, miCanvas.width, miCanvas.height)
}

buttonClearCanvas.addEventListener("click",
    function limpiandoFirma() {
        ctx.clearRect(0, 0, cw, ch)
        escribiendoEnCanvas();
    }, false
);