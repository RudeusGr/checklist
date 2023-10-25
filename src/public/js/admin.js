function getAllRoutesData() {
    fetch('http://192.168.1.12/corona/api/admin/dataroutes')
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
                    document.getElementById('custom-routes-body').innerHTML += `
                    <div class="custom-table-row">
                        <div class="labels">
                            <label>${element['name']}</label>
                        </div>
                        <div class="labels">
                            <label>${element['operador']}</label>
                        </div>
                        <div class="labels">
                            <input type="button" class="hidden-n-mobile" value="Eliminar" onclick="deleteRoute(${element['id']})" />
                            <img role="button" class="visible-n-mobile icon" src="src/public/icon/delete.svg" onclick="deleteRoute(${element['id']})" alt="Delete Icon">
                        </div>
                    </div>
                    `;
                    });
                }
            });
}

function getAllUsersData() {
    fetch('http://192.168.1.12/corona/api/admin/datausers')
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
                    document.getElementById('custom-users-body').innerHTML += `
                    <div class="custom-table-row">
                        <div class="labels">
                            <label>${element['username']}</label>
                        </div>
                        <div class="labels">
                            <label>${element['name']}</label>
                        </div>
                        <div class="labels">
                            <input type="button" class="hidden-n-mobile" value="Eliminar" onclick="deleteUser(${element['id']})" />
                            <img role="button" class="visible-n-mobile icon" src="src/public/icon/delete.svg" onclick="deleteUser(${element['id']})" alt="Delete Icon">
                        </div>
                    </div>
                    `;
                    });
                }
            });
}

function getAllStoresData() {
    fetch('http://192.168.1.12/corona/api/admin/datastores')
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
                    document.getElementById('custom-stores-body').innerHTML += `
                    <div class="custom-table-row">
                        <div class="labels">
                            <label>${element['code']}</label>
                        </div>
                        <div class="labels">
                            <label>${element['name']}</label>
                        </div>
                        <div class="labels">
                            <input type="button" class="hidden-n-mobile" value="Eliminar" onclick="deleteStores(${element['id']})" />
                            <img role="button" class="visible-n-mobile icon" src="src/public/icon/delete.svg" onclick="deleteStores(${element['id']})" alt="Delete Icon">
                        </div>
                    </div>
                    `;
                    });
                }
            });
}

function deleteRoute(id) {
    let data = { id: id }
    Swal.fire({
        title: 'Confirmacion',
        text: '¿Desea eliminar la ruta?',
        showDenyButton: true,
        confirmButtonText: 'Cancelar',
        denyButtonText: 'Eliminar',
    })
        .then((result) => {
            if (!result.isConfirmed) {
                fetch('http://192.168.1.12/corona/api/admin/deleteroute', {
                    method: "DELETE",
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .then((res) => res.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire({
                                title: 'Eliminación fallida!',
                                text: 'Ocurrio un error al intentar eliminar la ruta',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            Swal.fire({
                                title: 'Eliminación exitosa',
                                text: 'Ruta eliminada exitosamente',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                            cleanTables();
                            getAllRoutesData();
                        }
                    })
            }
        });
}

function deleteUser(id) {
    let data = { id: id }
    Swal.fire({
        title: 'Confirmacion',
        text: '¿Desea eliminar el usuario?',
        showDenyButton: true,
        confirmButtonText: 'Cancelar',
        denyButtonText: 'Eliminar',
    })
        .then((result) => {
            if (!result.isConfirmed) {
                fetch('http://192.168.1.12/corona/api/admin/deleteuser', {
                    method: "DELETE",
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .then((res) => res.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire({
                                title: 'Eliminación fallida!',
                                text: 'Ocurrio un error al eliminar el usuario',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        } else {
                            Swal.fire({
                                title: 'Eliminación exitosa!',
                                text: 'Usuario eliminado exitosamente',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                            cleanTables();
                            getAllUsersData();
                        }
                    })
            }
        });
}

function deleteStores(id) {
    let data = { id: id }
    Swal.fire({
        title: 'Confirmacion',
        text: '¿Desea eliminar la sucursal?',
        showDenyButton: true,
        confirmButtonText: 'Cancelar',
        denyButtonText: 'Eliminar',
    })
        .then((result) => {
            if (!result.isConfirmed) {
                fetch('http://192.168.1.12/corona/api/admin/deletestore', {
                    method: "DELETE",
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .then((res) => res.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire({
                                title: 'Eliminación fallida!',
                                text: 'Ocurrio un error al eliminar la sucursal',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        } else {
                            Swal.fire({
                                title: 'Eliminación exitosa!',
                                text: 'Sucursal eliminada exitosamente',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                            cleanTables();
                            getAllStoresData();
                        }
                    })
            }
        });
}

function cleanTables() {
    document.getElementById('custom-routes-body').innerHTML = '';
    document.getElementById('custom-users-body').innerHTML = '';
    document.getElementById('custom-stores-body').innerHTML = '';
}

function cleanInputs() {
    document.getElementById('routeName').value = '';
    document.getElementById('routeOperador').value = '';
    document.getElementById('userUsername').value = '';
    document.getElementById('userName').value = '';
    document.getElementById('userPassword').value = '';
    document.getElementById('branchName').value = '';
    document.getElementById('storeName').value = '';
}

document.getElementById("btnroutes").addEventListener("click", (evt) => {
    document.getElementById('title').innerText = "Administración de rutas";
    document.getElementById('tableroutes').style.display = "grid";
    document.getElementById('tableusers').style.display = "none";
    document.getElementById('tablestores').style.display = "none";
    document.getElementById('btn-open-route').style.display = "initial";
    document.getElementById('btn-open-user').style.display = "none";
    document.getElementById('btn-open-store').style.display = "none";
    cleanTables();
    getAllRoutesData();
});

document.getElementById("btnusers").addEventListener("click", (evt) => {
    evt.preventDefault();
    document.getElementById('title').innerText = "Administración de usuarios";
    document.getElementById('tableroutes').style.display = "none";
    document.getElementById('tableusers').style.display = "grid";
    document.getElementById('tablestores').style.display = "none";
    document.getElementById('btn-open-route').style.display = "none";
    document.getElementById('btn-open-user').style.display = "initial";
    document.getElementById('btn-open-store').style.display = "none";
    cleanTables();
    getAllUsersData();
});

document.getElementById("btnstores").addEventListener("click", (evt) => {
    document.getElementById('title').innerText = "Administración de tiendas";
    document.getElementById('tableroutes').style.display = "none";
    document.getElementById('tableusers').style.display = "none";
    document.getElementById('tablestores').style.display = "grid";
    document.getElementById('btn-open-route').style.display = "none";
    document.getElementById('btn-open-user').style.display = "none";
    document.getElementById('btn-open-store').style.display = "initial"
    cleanTables();
    getAllStoresData();
});

/***********************Test modal rutas */

const modalroute = document.getElementById("modalroute");
const overlayroute = document.getElementById("overlayroute");
const openModalBtnroute = document.getElementById("btn-open-route");
const closeModalBtnroute = document.getElementById("btn-close-route");

const closeModalRoute = function () {
    cleanInputs();
    modalroute.classList.add("hidden");
    overlayroute.classList.add("hidden");
};

closeModalBtnroute.addEventListener("click", closeModalRoute);
overlayroute.addEventListener("click", closeModalRoute);

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && !modalroute.classList.contains("hidden")) {
        cleanInputs();
        closeModalRoute();
    }
});

const openModalRoute = function () {
    modalroute.classList.remove("hidden");
    overlayroute.classList.remove("hidden");
};

openModalBtnroute.addEventListener("click", openModalRoute);


/*********************************test modal user */

const modaluser = document.getElementById("modaluser");
const overlayuser = document.getElementById("overlayuser");
const openModalBtnuser = document.getElementById("btn-open-user");
const closeModalBtnuser = document.getElementById("btn-close-user");

const closeModalUser = function () {
    cleanInputs();
    modaluser.classList.add("hidden");
    overlayuser.classList.add("hidden");
};

closeModalBtnuser.addEventListener("click", closeModalUser);
overlayuser.addEventListener("click", closeModalUser);

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && !modaluser.classList.contains("hidden")) {
        cleanInputs();
        closeModalUser();
    }
});

const openModalUser = function () {
    modaluser.classList.remove("hidden");
    overlayuser.classList.remove("hidden");
};

openModalBtnuser.addEventListener("click", openModalUser);


/***********************Test modal sucursales */

const modalstore = document.getElementById("modalstore");
const overlaystore = document.getElementById("overlaystore");
const openModalBtnstore = document.getElementById("btn-open-store");
const closeModalBtnstore = document.getElementById("btn-close-store");

const closeModalStore = function () {
    cleanInputs();
    modalstore.classList.add("hidden");
    overlaystore.classList.add("hidden");
};

closeModalBtnstore.addEventListener("click", closeModalStore);
overlaystore.addEventListener("click", closeModalStore);

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && !modalstore.classList.contains("hidden")) {
        cleanInputs();
        closeModalStore();
    }
});

const openModalStore = function () {
    modalstore.classList.remove("hidden");
    overlaystore.classList.remove("hidden");
};

openModalBtnstore.addEventListener("click", openModalStore);


/****************** Agregar Rutas, Usuarios y Sucursales **********************/

function validateDataRoute() {
    let routeName = document.getElementById('routeName').value;
    let routeOperador = document.getElementById('routeOperador').value;

    if (routeName == '' || routeOperador == '') {
        Swal.fire({
            title: 'Advertencia!',
            text: 'Falta información de ruta',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
        return false;
    }
    return true;
}

document.getElementById("save-route").addEventListener("click", (evt) => {
    evt.preventDefault();
    postDataRoute();
});


function postDataRoute() {
    if (validateDataRoute()) {
        data = {
            operador: document.getElementById('routeOperador').value,
            name: document.getElementById('routeName').value
        }
        fetch('http://192.168.1.12/corona/api/admin/saveroute', {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((res) => res.json())
            .then(data => {
                if (data.error) {
                    Swal.fire({
                        title: 'Registro fallido!',
                        text: 'Ocurrio un error al intentar registrar',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    closeModalRoute();
                } else {
                    cleanTables();
                    getAllRoutesData();
                    closeModalRoute();
                    Swal.fire({
                        title: 'Registro correcto!',
                        text: 'Ruta registrada exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                }
            })
    }
}

function validateDataUser() {
    let username = document.getElementById('userUsername').value;
    let name = document.getElementById('userName').value;
    let password = document.getElementById('userPassword').value;

    if (username == '' || name == '' || password == '') {
        Swal.fire({
            title: 'Advertencia!',
            text: 'Falta información de Usuarios',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
        return false;
    }
    return true;
}

document.getElementById("save-user").addEventListener("click", (evt) => {
    evt.preventDefault();
    postDataUser();
});

function postDataUser() {
    if (validateDataUser()) {
        data = {
            username: document.getElementById('userUsername').value,
            name: document.getElementById('userName').value,
            password: document.getElementById('userPassword').value
        }
        fetch('http://192.168.1.12/corona/api/admin/saveuser', {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((res) => res.json())
            .then(data => {
                if (data.error) {
                    Swal.fire({
                        title: 'Registro fallido!',
                        text: 'Ocurrio un error al intentar registrar',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    closeModalUser();
                } else {
                    cleanTables();
                    getAllUsersData();
                    closeModalUser();
                    Swal.fire({
                        title: 'Registro correcto!',
                        text: 'Usuario registrado exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                }
            })
    }
}

function validateDataStore() {
    let branchName = document.getElementById('branchName').value;
    let storeName = document.getElementById('storeName').value;

    if (branchName == '' || storeName == '') {
        Swal.fire({
            title: 'Advertencia!',
            text: 'Falta información de la tienda',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
        return false;
    }
    return true;
}

document.getElementById("save-store").addEventListener("click", (evt) => {
    evt.preventDefault();
    postDataStore();
});


function postDataStore() {
    if (validateDataStore()) {
        data = {
            branchName: document.getElementById('branchName').value,
            storeName: document.getElementById('storeName').value
        }
        fetch('http://192.168.1.12/corona/api/admin/savestore', {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((res) => res.json())
            .then(data => {
                if (data.error) {
                    Swal.fire({
                        title: 'Registro fallido!',
                        text: 'Ocurrio un error al intentar registrar',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    closeModalStore();
                } else {
                    cleanTables();
                    getAllStoresData();
                    closeModalStore();
                    Swal.fire({
                        title: 'Registro correcto!',
                        text: 'Sucursal registrada exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                }
            })
    }
}