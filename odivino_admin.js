console.log("odivino_admin.js executed");

wp.api.loadPromise.done(function () {
  //... use the client here
  console.log("Loaded REST API");
  console.log(wp.api.models);
});
