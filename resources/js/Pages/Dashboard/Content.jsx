import React from "react";
import Category from "./Categories/Category";

const Content = ({ currentPage }) => {
    return (
        <div className="flex-1 p-6">
            <div className="text-gray-600 text-sm mb-4">
                <p>
                    Dashboard /{" "}
                    <span className="text-blue-500">{currentPage}</span>
                </p>
            </div>

            {currentPage === "Dashboard" && (
                <p>
                    Welcome to the Dashboard! Here's a quick overview of your
                    data.
                </p>
            )}

            {currentPage === "Categories" && <Category />}

            {currentPage === "Items" && (
                <p>View and edit your inventory items.</p>
            )}
            {currentPage === "Customers" && (
                <p>See your customer list and manage profiles.</p>
            )}
            {currentPage === "Pages" && <p>Manage website pages here.</p>}
            {currentPage === "Applications" && (
                <p>Access various applications integrated with the system.</p>
            )}
            {currentPage === "My Profile" && (
                <p>Update your personal profile here.</p>
            )}
            {currentPage === "Company Profile" && (
                <p>Edit your company's profile and details.</p>
            )}
            {currentPage === "Change Password" && (
                <p>Change your account password securely here.</p>
            )}
        </div>
    );
};

export default Content;
