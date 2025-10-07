import React from "react";

export default function Home() {
  return (
    <main className="home-page">
      <section className="hero">
        <div className="container">
          <h1>Welcome to XMVC Framework</h1>
          <p>
            This is your new PHP + React hybrid application — lightweight, modular, and fast.
          </p>

          <div className="cta-buttons">
            <a href="/about" className="btn btn-primary">Learn More</a>
            <a href="/contact" className="btn btn-outline">Contact Us</a>
          </div>
        </div>
      </section>
    </main>
  );
}
