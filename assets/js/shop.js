RestClient.get("get_product.php?id=39", function (data) {
  console.log("DATA", data);
});

RestClient.get("get_products.php", function (data) {
  console.log("DATA", data);
});

const product = {
  name: "Riki Novi",
  brand: "Riki",
  description: "Riki",
  gender: "Male",
  category: "Shoes",
  rating: 1,
  price: 100.99,
};

if (confirm("Are you sure")) {
  RestClient.post("add_product.php?id=40", product, function (data) {
    console.log("ADDED ", data);    //ako ima id onda ce da editati na ove info iznad(sav info) a ako nema onda ga samo adda u tabelu (id=39)
  });
}

if (confirm("delete?")) {
  RestClient.delete("delete_product.php?id=41", function (data) {
    console.log("DELETED", data);
  });
}
