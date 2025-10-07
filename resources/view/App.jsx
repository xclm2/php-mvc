import React, {useState, useEffect, use} from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Routes, Route, Link } from "react-router-dom";
import "../../resources/theme/xcl/scss/main.scss";

import Nav from "./components/nav";


function App() {
  return <Nav />;
}

ReactDOM.createRoot(document.getElementById("app")).render(<App />);
