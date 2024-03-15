import "./bootstrap";
import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);
// import './validations/validations'

// app.js

// Import the file if the current route matches the specified route name
if (window.location.pathname === "/admin") {
    import("./graph/acquisitions")
        .then((module) => {
            console.log("File imported successfully");
            // You can do additional setup here if needed
        })
        .catch((error) => {
            console.error("Error importing file:", error);
        });
}
