import {useState} from "react";
import { BrowserRouter, Routes, Route, Link } from "react-router-dom";

function About() {
  return <h1>About Page</h1>;
}

function ContactUs() {
  return <h1>Contact Us Page</h1>;
}
export default function Nav() {
    let [active, setActive] = useState('home');
    return (
        <BrowserRouter>
            <nav>
                <ul>
                    <li><Link to="/about">About</Link></li>
                    <li><Link to="/contact">Contact</Link></li>
                </ul>
            </nav>

            <Routes>
                <Route path="/about" element={<About />} />
                <Route path="/contact" element={<ContactUs />} />
            </Routes>
        </BrowserRouter>
    );
}