const addForm = document.querySelector("#addForm_ID");
const tableList = document.querySelector("#list_id");
const p_nameValue = document.getElementById("p_name");
const detailValue = document.getElementById("p_details");
const priceValue = document.getElementById("p_price");
const categoryValue = document.getElementById("p_category");
var pname = document.getElementById("productNameValidation");
var x = document.getElementById("p_name");
// Update value
const output = document.querySelector("#output");
const btnSubmit = document.querySelector("#btnSubmit");
const url = "https://jsonplaceholder.typicode.com/users";
const deurl = "http://localhost/sct/api/products/delete.php";
//modals
const open = document.getElementById("open");
const title = document.getElementById("title");
const productNameValidation = document.getElementById("productNameValidation");
const modal_container = document.getElementById("modal-container");
const close = document.getElementById("close");

loadCategory();
showdata();
open.addEventListener("click", () => {
  modal_container.classList.add("show");
  title.innerHTML = "Add New Product";
  close.addEventListener("click", () => {
    p_nameValue.value = "";
    detailValue.value = "";
    priceValue.value = "";
    categoryValue.value = "";
    pname.innerHTML = "";

    modal_container.classList.remove("show");
  });
});
//modals ends
function updateDiv() {
  document.getElementById("list_id").innerHTML =
    document.getElementById("list_id").innerHTML;
}
//LOAD CATAGORY DATA
function loadCategory() {
  // fetch categories data
  fetch("http://localhost/sct/api/products/read_categories.php")
    .then((response) => response.json())
    .then((data) => renderCategory(data));
}
const renderCategory = (cats) => {
  cats.forEach((cat) => {
    const cat_id = document.createElement("option");
    cat_id.text = cat.name;
    cat_id.value = cat.id;
    p_category.appendChild(cat_id);
  });
};
////////////////////////////////
//All validation
////////////////////////////////
// Product Name Validation
function nameValidation() {
  if (x.value.length < 3) {
    pname.innerHTML = "Product Name must have at least 4 characters";
    productNameValidation.classList.add("show");
    // pname.classList.add("visible");
  }
  if (x.value.length > 3 && x.value.length < 19) {
    pname.innerHTML = "";
  }
  if (x.value.length > 20) {
    pname.innerHTML = "Product Name more than 20 characters";
  }
}
function restrict(tis) {
  var prev = tis.getAttribute("data-prev");
  prev = prev != "" ? prev : "";
  if (Math.round(tis.value * 100) / 100 != tis.value) tis.value = prev;
  tis.setAttribute("data-prev", tis.value);
}

//PRICE VALIDATION
function priceValidation(evt) {
  var charCode = evt.which ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

  return true;
}
//VALIDATION ENDS
////////////////////////////////////////////////////////////////
const renderUser = (users) => {
  let out = "";
  users.forEach((user) => {
    out += `
            <tr data-id=${user.id} data-cid=${user.p_category}>
                <td class="border border-slate-600" id="name_id" >${user.p_name}</td>
                <td class="border border-slate-600" id="detail_id" >${user.p_details}</td>
                <td class="border border-slate-600" id="price_id" >${user.p_price}</td>
                <td class="border border-slate-600" id="category_id" >${user.category_name}</td>
                <td class="p-2 border border-slate-600 text-center"><a id="id_delete">Delete</a></td>
                <td class="p-2 border border-slate-600 text-center"><a id="id_edit">Update</a></td>
                
            </tr>
            
            `;
  });

  output.innerHTML = out;
};

//SHOW DATA
function showdata() {
  p_nameValue.value = "";
  detailValue.value = "";
  priceValue.value = "";
  categoryValue.value = "";
  cid = "";
  pname.innerHTML = "";
  modal_container.classList.remove("show");
  fetch("http://localhost/sct/api/products/read.php")
    .then((response) => response.json())
    .then((data) => renderUser(data));
}

//DELETE OPATARION
tableList.addEventListener("click", (e) => {
  e.preventDefault();
  let onPressDelete = e.target.id == "id_delete";
  let onPressedit = e.target.id == "id_edit";
  let id = e.target.parentElement.parentElement.dataset.id;
  const parent = e.target.parentElement.parentElement;
  if (onPressDelete) {
    var result = confirm("Want to delete?");
    if (result) {
      fetch("http://localhost/sct/api/products/delete.php", {
        method: "DELETE",
        body: JSON.stringify({
          id: id,
        }),
      })
        .then(() => showdata())
        .then((res) => res.json());
    }
  }
  if (onPressedit) {
    const modal_container = document.getElementById("modal-container");
    modal_container.classList.add("show");
    title.innerHTML = "Update Product";

    const close = document.getElementById("close");
    close.addEventListener("click", () => {
      modal_container.classList.remove("show");
    });

    let cid = e.target.parentElement.parentElement.dataset.cid;
    const p_name = parent.querySelector("#name_id").textContent;
    const detail_id = parent.querySelector("#detail_id").textContent;
    const price_id = parent.querySelector("#price_id").textContent;
    // POPULATING DATA
    p_nameValue.value = p_name;
    detailValue.value = detail_id;
    priceValue.value = price_id;
    categoryValue.value = cid;
    console.log(cid);
    console.log(p_nameValue.value);
    console.log(detailValue.value);
    console.log(p_price.value);
  }
  //UPDATE OPARATION
  btnSubmit.addEventListener("click", (e) => {
    e.preventDefault();
    fetch("http://localhost/sct/api/products/update.php", {
      method: "PUT",
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify({
        id: id,
        p_name: p_nameValue.value,
        p_details: detailValue.value,
        p_category: p_category.value,
        p_price: p_price.value,
      }),
    })
      .then((res) => res.json())
      .then(() => showdata())
      .then(() => {
        id = "";
      });
  });
});

//CREATE PRODUCT
addForm.addEventListener("submit", (e) => {
  e.preventDefault();
  console.log(categoryValue.value);
  if (isNaN(categoryValue.value)) {
    pname.innerHTML = "Please Select a Category";
  } else if (
    p_nameValue.value.length > 4 &&
    p_nameValue.value.length < 20 &&
    categoryValue.value.length > 0
  ) {
    fetch("http://localhost/sct/api/products/create.php", {
      method: "POST",
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify({
        ProductName: p_nameValue.value,
        ProductDetails: detailValue.value,
        categoriy_id: categoryValue.value,
        ProductPrice: p_price.value,
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        const dataArr = [];
        dataArr.push(data);
        renderUser(dataArr);
      })
      .then(() => showdata());
  } else {
    alert("Enter at least 4 charecter and not more than 20 characters");
  }
});
