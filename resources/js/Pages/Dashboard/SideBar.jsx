import React, { useState, useEffect } from "react";
import {
    FaRocket,
    FaCog,
    FaGlobe,
    FaUser,
    FaArrowRight,
    FaBuilding,
    FaSync,
} from "react-icons/fa";

const Sidebar = ({ onMenuClick }) => {
    const [isAdminOpen, setIsAdminOpen] = useState(false);
    const [isPagesOpen, setIsPagesOpen] = useState(false);
    const [isAppsOpen, setIsAppsOpen] = useState(false);
    const [selectedMenu, setSelectedMenu] = useState("Dashboard");

    const toggleMenu = (menu) => {
        switch (menu) {
            case "Administration":
                setIsAdminOpen(!isAdminOpen);
                break;
            case "Pages":
                setIsPagesOpen(!isPagesOpen);
                break;
            case "Applications":
                setIsAppsOpen(!isAppsOpen);
                break;
            default:
                break;
        }
    };

    const handleMenuClick = (menu) => {
        setSelectedMenu(menu);
        onMenuClick(menu);
    };

    useEffect(() => {
        if (!selectedMenu) {
            setSelectedMenu("Dashboard");
        }
    }, [selectedMenu]);

    return (
        <div className="p-4 w-80 h-screen bg-white flex flex-col shadow-lg">
            {/* Navigation */}
            <nav className="flex-1 overflow-y-auto">
                <ul className="vertical-nav-menu space-y-4">
                    <li className="text-lg font-bold text-blue-500 uppercase">
                        Menu
                    </li>

                    {/* Dashboards */}
                    <li>
                        <a
                            className={`flex items-center gap-3 px-4 py-3 text-base font-medium rounded-md cursor-pointer ${
                                selectedMenu === "Dashboard"
                                    ? "bg-blue-100 text-blue-600"
                                    : "text-gray-700 hover:bg-blue-100 hover:text-blue-600"
                            }`}
                            onClick={() => handleMenuClick("Dashboard")}
                        >
                            <FaRocket className="text-blue-500 text-lg" />
                            Dashboards
                        </a>
                    </li>

                    {/* Administration */}
                    <li>
                        <a
                            className={`mb-1 flex items-center justify-between px-4 py-3 text-base font-medium rounded-md cursor-pointer ${
                                isAdminOpen
                                    ? "bg-blue-100 text-blue-600"
                                    : "text-gray-700 hover:bg-blue-100 hover:text-blue-600"
                            }`}
                            onClick={() => toggleMenu("Administration")}
                        >
                            <div className="flex items-center gap-3">
                                <FaCog className="text-blue-500 text-lg" />
                                Administration
                            </div>
                            <FaArrowRight
                                className={`text-sm text-gray-500 transform transition ${
                                    isAdminOpen ? "rotate-90" : ""
                                }`}
                            />
                        </a>
                        {isAdminOpen && (
                            <ul className="pl-10 flex flex-col gap-1">
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "Categories"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() =>
                                            handleMenuClick("Categories")
                                        }
                                    >
                                        Categories
                                    </a>
                                </li>
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "Items"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() => handleMenuClick("Items")}
                                    >
                                        Items
                                    </a>
                                </li>
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "Customers"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() =>
                                            handleMenuClick("Customers")
                                        }
                                    >
                                        Customers
                                    </a>
                                </li>
                            </ul>
                        )}
                    </li>

                    {/* Pages */}
                    <li>
                        <a
                            className={`mb-1 flex items-center justify-between px-4 py-3 text-base font-medium rounded-md cursor-pointer ${
                                isPagesOpen
                                    ? "bg-blue-100 text-blue-600"
                                    : "text-gray-700 hover:bg-blue-100 hover:text-blue-600"
                            }`}
                            onClick={() => toggleMenu("Pages")}
                        >
                            <div className="flex items-center gap-3">
                                <FaGlobe className="text-blue-500 text-lg" />
                                Pages
                            </div>
                            <FaArrowRight
                                className={`text-sm text-gray-500 transform transition ${
                                    isPagesOpen ? "rotate-90" : ""
                                }`}
                            />
                        </a>
                        {isPagesOpen && (
                            <ul className="pl-10 flex flex-col gap-1">
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "Login"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() => handleMenuClick("Login")}
                                    >
                                        Login
                                    </a>
                                </li>
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "Register"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() =>
                                            handleMenuClick("Register")
                                        }
                                    >
                                        Register
                                    </a>
                                </li>
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "Forgot Password"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() =>
                                            handleMenuClick("Forgot Password")
                                        }
                                    >
                                        Forgot Password
                                    </a>
                                </li>
                            </ul>
                        )}
                    </li>

                    {/* Applications */}
                    <li>
                        <a
                            className={`mb-1 flex items-center justify-between px-4 py-3 text-base font-medium rounded-md cursor-pointer ${
                                isAppsOpen
                                    ? "bg-blue-100 text-blue-600"
                                    : "text-gray-700 hover:bg-blue-100 hover:text-blue-600"
                            }`}
                            onClick={() => toggleMenu("Applications")}
                        >
                            <div className="flex items-center gap-3">
                                <FaRocket className="text-blue-500 text-lg" />
                                Applications
                            </div>
                            <FaArrowRight
                                className={`text-sm text-gray-500 transform transition ${
                                    isAppsOpen ? "rotate-90" : ""
                                }`}
                            />
                        </a>
                        {isAppsOpen && (
                            <ul className="pl-10 flex flex-col gap-1">
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "Mailbox"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() =>
                                            handleMenuClick("Mailbox")
                                        }
                                    >
                                        Mailbox
                                    </a>
                                </li>
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "Chat"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() => handleMenuClick("Chat")}
                                    >
                                        Chat
                                    </a>
                                </li>
                                <li>
                                    <a
                                        className={`p-2 block text-sm font-medium rounded-md cursor-pointer ${
                                            selectedMenu === "FAQ Section"
                                                ? "bg-blue-100 text-blue-600"
                                                : "text-gray-600 hover:bg-blue-100 hover:text-blue-600"
                                        }`}
                                        onClick={() =>
                                            handleMenuClick("FAQ Section")
                                        }
                                    >
                                        FAQ Section
                                    </a>
                                </li>
                            </ul>
                        )}
                    </li>

                    <li className="mt-4 text-lg font-bold text-blue-500 uppercase">
                        My Account
                    </li>
                    <li>
                        <a
                            className={`flex items-center gap-3 px-4 py-3 text-base font-medium rounded-md cursor-pointer ${
                                selectedMenu === "My Profile"
                                    ? "bg-blue-100 text-blue-600"
                                    : "text-gray-700 hover:bg-blue-100 hover:text-blue-600"
                            }`}
                            onClick={() => handleMenuClick("My Profile")}
                        >
                            <FaUser className="text-blue-500 text-lg" />
                            My Profile
                        </a>
                    </li>
                    <li>
                        <a
                            className={`flex items-center gap-3 px-4 py-3 text-base font-medium rounded-md cursor-pointer ${
                                selectedMenu === "Company Profile"
                                    ? "bg-blue-100 text-blue-600"
                                    : "text-gray-700 hover:bg-blue-100 hover:text-blue-600"
                            }`}
                            onClick={() => handleMenuClick("Company Profile")}
                        >
                            <FaBuilding className="text-blue-500 text-lg" />
                            Company Profile
                        </a>
                    </li>
                    <li>
                        <a
                            className={`flex items-center gap-3 px-4 py-3 text-base font-medium rounded-md cursor-pointer ${
                                selectedMenu === "Change Password"
                                    ? "bg-blue-100 text-blue-600"
                                    : "text-gray-700 hover:bg-blue-100 hover:text-blue-600"
                            }`}
                            onClick={() => handleMenuClick("Change Password")}
                        >
                            <FaSync className="text-blue-500 text-lg" />
                            Change Password
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    );
};

export default Sidebar;
