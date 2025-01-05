// Selección de elementos del DOM
const frm = document.getElementById("frm");
const resultado = document.getElementById("resultado");
const buscar = document.getElementById("buscar");
const buscarId = document.getElementById("buscarId");
const registrar = document.getElementById("registrar");

// Función para listar productos
function ListarProductos(busqueda = "") {
    const url = busqueda
        ? `vistaProducto.php?producto=${encodeURIComponent(busqueda)}`
        : "vistaProducto.php?t=1";

    fetch(url, {
        method: "GET"
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al listar productos");
            return response.json();
        })
        .then(data => {
            resultado.innerHTML = "";


            if (data.data && data.data.length > 0) {
                data.data.forEach(producto => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                    <td>${producto.id}</td>
                    <td>${producto.codigo}</td>
                    <td>${producto.producto}</td>
                    <td>${producto.precio}</td>
                    <td>${producto.cantidad}</td>
                    <td>
                        <button type='button' class='btn btn-success' onclick=Editar('${producto.id}')>Editar</button>
                        <button type='button' class='btn btn-danger' onclick=Eliminar('${producto.id}')>Eliminar</button>
                    </td>
                `;
                    resultado.appendChild(row);
                });
            } else {
                resultado.innerHTML = "<tr><td colspan='6'>No se encontraron productos.</td></tr>";
            }
        })
        .catch(error => console.error("Error:", error));
}


// Función para buscar producto por ID
function BuscarProductoPorID(id) {
    const url = `vistaProducto.php?id=${id}`;

    fetch(url, {
        method: "GET"
    })
        .then(response => {
            if (!response.ok) throw new Error("Error al buscar producto por ID");
            return response.json();
        })
        .then(producto => {
            
            resultado.innerHTML = "";

            // Comprobar si se recibió un producto
            if (producto && producto.id) {
                const row = document.createElement("tr");
                row.innerHTML = `
                <td>${producto.id}</td>
                <td>${producto.codigo}</td>
                <td>${producto.producto}</td>
                <td>${producto.precio}</td>
                <td>${producto.cantidad}</td>
                <td>
                    <button type='button' class='btn btn-success' onclick=Editar('${producto.id}')>Editar</button>
                    <button type='button' class='btn btn-danger' onclick=Eliminar('${producto.id}')>Eliminar</button>
                </td>
            `;
                resultado.appendChild(row); // Añadir la fila al contenedor
            } else {
                
                resultado.innerHTML = "<tr><td colspan='6'>Producto no encontrado.</td></tr>";
            }
        })
        .catch(error => console.error("Error:", error));
}



// Evento para registrar o actualizar productos
registrar.addEventListener("click", () => {
    const frm = document.getElementById("frm");
    const id = document.getElementById("idp").value;
    const url = id ? "vistaProducto.php" : "vistaProducto.php";

    const formData = new FormData(frm);

    if (!id) {
        formData.delete("idp");
    }

    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
    })
    .then(response => {
        if (!response.ok) throw new Error("Error al registrar/actualizar producto");
        return response.text(); 
    })
    .then(data => {
        if (data.trim() === "ok") { 
            Swal.fire({
                icon: 'success',
                title: id ? 'Producto actualizado' : 'Producto registrado',
                showConfirmButton: false,
                timer: 1500
            });
            frm.reset();
            registrar.value = "Registrar";
            ListarProductos();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data
            });
        }
    })
    .catch(error => console.error("Error:", error));
    
});

// Función para editar productos
function Editar(id) {
    fetch(`vistaProducto.php?id=${id}`, {
        method: "GET"
    }).then(response => response.json()).then(response => {
        idp.value = response.id;
        codigo.value = response.codigo;
        producto.value = response.producto;
        precio.value = response.precio;
        cantidad.value = response.cantidad;
        registrar.value = "Actualizar"
    })
}

// Función para eliminar productos
function Eliminar(id) {
    Swal.fire({
        title: '¿Está seguro de eliminar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("vistaProducto.php", {
                method: "DELETE", 
                headers: {
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify({ delete: id })
            })
            .then(response => response.text())
            .then(response => {
                if (response.trim() === "ok") {
                    ListarProductos();
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el producto.'
                    });
                }
            })
            .catch(error => console.error("Error:", error)); 
        }
    });
}


// Evento para buscar productos por nombre
buscar.addEventListener("keyup", () => {
    const valor = buscar.value.trim();
    ListarProductos(valor);
});

// Evento para buscar productos por ID
buscarId.addEventListener("keyup", () => {
    const id = buscarId.value.trim();
    if (id) {
        BuscarProductoPorID(id);
    } else {
        ListarProductos();
    }
});

// Inicializar la lista de productos al cargar la página
document.addEventListener("DOMContentLoaded", () => {
    ListarProductos();
});
