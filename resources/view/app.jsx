import React from "react";
import { createRoot } from "react-dom/client";
import {useState, useEffect} from "react";
import "../../resources/theme/xcl/scss/main.scss";

function App() {
  return <h1>Hello from React + PHP + Vite!</h1>;
}
function Nav() {
    let [active, setActive] = useState('home');
    return (
        <nav>
            <ul>
                <li onClick={() => setActive('home')} class={active === 'home' ? 'active' : ''}><a href="#">Home</a></li>
                <li onClick={() => setActive('about')} class={active === 'about' ? 'active' : ''}><a href="#">About</a></li>
                <li onClick={() => setActive('contact')} class={active === 'contact' ? 'active' : ''}><a href="#">Contact</a></li>
            </ul>
        </nav>
    );
}
const root = createRoot(document.getElementById("app"));
root.render(
    <>
        <Nav />
        <App />
    </>
);
