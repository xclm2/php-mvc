import {useState} from "react";
import { BrowserRouter, Routes, Route, Link } from "react-router-dom";

function Home() {
    return <h1>Home Page</h1>;
}

function About() {
  return <h1>About Page</h1>;
}

function ContactUs() {
  return <h1>Contact Us Page</h1>;
}
export default function Nav() {
    let [active, setActive] = useState(window.location.pathname);
    return (
        <BrowserRouter>
            <nav>
                <ul>
                    <li onClick={() => setActive('/')} className={active === '/' ? 'active' : '' }><Link to="/" >Home</Link></li>
                    <li onClick={() => setActive('/about')}  className={active === '/about' ? 'active' : '' }><Link to="/about">About</Link></li>
                    <li onClick={() => setActive('/contact')}  className={active === '/contact' ? 'active' : '' }><Link to="/contact">Contact</Link></li>
                </ul>
            </nav>

            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/about" element={<About />} />
                <Route path="/contact" element={<ContactUs />} />
            </Routes>
        </BrowserRouter>
    );
}