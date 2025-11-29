const API_USUARIOS = "http://127.0.0.1:8090";


const API_TICKETS  = "http://127.0.0.1:8002";


function saveSession(data) {
    localStorage.setItem("token", data.token);
    localStorage.setItem("role", data.role);
    localStorage.setItem("user_id", data.user_id);
}

function getToken() {
    return localStorage.getItem("token");
}

function getRole() {
    return localStorage.getItem("role");
}

function getUserId() {
    return localStorage.getItem("user_id");
}

function limpiarSession() {
    localStorage.removeItem("token");
    localStorage.removeItem("role");
    localStorage.removeItem("user_id");
}

function logout() {
    const token = getToken();
    if (!token) {
        limpiarSession();
        window.location.href = "../login.html";
        return;
    }

    fetch(API_USUARIOS + "/usuarios/logout", {
        method: "POST",
        headers: {
            "token": token
        }
    })
    .finally(() => {
        limpiarSession();
        window.location.href = "../login.html";
    });
}



function verificarSesion(rolRequerido = null) {
    const token = getToken();
    const role  = getRole();

    if (!token) {
        alert("Debe iniciar sesión");

        if (window.location.pathname.includes("/gestor/") ||
            window.location.pathname.includes("/admin/")) {
            window.location.href = "../login.html";
        } else {
            window.location.href = "login.html";
        }
        return;
    }

    if (rolRequerido && role !== rolRequerido) {
        alert("No tiene permisos para ver esta página");
        if (role === "gestor") {
            window.location.href = "../gestor/panel.html";
        } else if (role === "admin") {
            window.location.href = "../admin/panel.html";
        } else {
            window.location.href = "../login.html";
        }
    }
}
