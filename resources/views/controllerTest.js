
var urlProduct="localhost/ferrerMtest/public/producto.php";


function updateProduct(){
    var xhr= new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState==4&&this.status==200){
            var respuesta = JSON.parse(xhr.responseText);
            getElementById('name').innerHTML(respuesta['name']);
            getElementById('description').innerHTML(respuesta['description']);
            getElementById('price').innerHTML(respuesta['price']);
            getElementById('created_at').innerHTML(respuesta['created_at']);
            getElementById('updated_at').innerHTML(respuesta['updated_at']);
        }else{

        }
        
    };
    xhr.open('PUT',urlProduct,true);
    xhr.send("name="+document.getElementById("name").value+"&description="+document.getElementById("description").value+"&price="+document.getElementById("price").value+"&id="+document.getElementById("productId").value);
};

function readProduct(productId){
    var xhr= new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if(this.readyState==4&&this.status==200){
            var respuesta= JSON.parse(xhr.responseText);
            document.getElementById('display').innerHTML="Leido!";
            document.getElementById('name').innerHTML=respuesta['name'];
        }
    };
    xhr.open('GET',urlProduct+"?id="+productId,true);
    xhr.send();
    
};

function  createProduct() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (){
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText==true){
                document.getElementById("display").innerHTML = "Created!";
            }
        }
    };
        
        xhttp.open("POST", urlProduct, true);
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.send("name="+document.getElementById("name").value+"&description="+document.getElementById("description").value+"&price="+document.getElementById("price").value);
    
};

function deleteProduct(){
    alert('Are you sure you want to delete item?');
    var productId=document.getElementById('productId').value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (){
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText!=true){
                
                document.getElementById("display").innerHTML = "Deleted!.";
                
            }
    
        }
    };
    xhttp.open("DELETE", urlProduct+"?id="+productId, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    
}