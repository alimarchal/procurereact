import React from "react";

const Footer = () => {
    return (
        <div>
            <div className="flex justify-center items-center h-14 bg-[#fafbfc] text-center d-block border border-[#e9ecef]">
                <b className="copyright">© 2025</b> - All rights reserved.
                Brought to you by{" "}
                <a href="#" target="_blank" className="ms-1 text-blue-500">
                    WebSoft Pvt Ltd
                </a>
                .
            </div>
        </div>
    );
};

export default Footer;
