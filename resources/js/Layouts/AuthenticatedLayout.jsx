import React, { useState } from "react";
import { FaBell, FaSearch, FaAngleDown } from "react-icons/fa";
import { usePage } from "@inertiajs/react";
import ResponsiveNavLink from "../Components/ResponsiveNavLink";

export default function AuthenticatedLayout({ header, children }) {
    const user = usePage().props.auth.user;

    const [searchOpen, setSearchOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);

    return (
        <div className="min-h-screen bg-gray-100">
            <nav className="p-6 shadow border-b border-gray-200 bg-white">
                <div className="flex flex-wrap justify-between items-center gap-y-4">
                    {/* Logo and Search Bar */}
                    <div className="flex items-center gap-10">
                        <span className="text-2xl font-bold">Architect</span>
                        <div className="relative">
                            {searchOpen ? (
                                <div className="flex items-center border rounded-full bg-gray-100 px-4">
                                    <input
                                        type="text"
                                        placeholder="Type to search"
                                        className="bg-transparent focus:outline-none border-none"
                                    />
                                    <FaSearch className="text-gray-500 ml-2" />
                                    <button
                                        onClick={() => setSearchOpen(false)}
                                        className="ml-2 text-gray-500"
                                    >
                                        X
                                    </button>
                                </div>
                            ) : (
                                <button
                                    onClick={() => setSearchOpen(true)}
                                    className="p-2 bg-gray-200 rounded-full text-blue-500"
                                >
                                    <FaSearch />
                                </button>
                            )}
                        </div>
                    </div>

                    {/* Notification, Flag, Vertical Line, Profile */}
                    <div className="flex items-center gap-4">
                        {/* Notification Icon */}
                        <button className="relative p-2 bg-red-200 rounded-full">
                            <FaBell className="text-red-500" />
                            <span className="absolute top-0 right-0 block h-2 w-2 bg-red-500 rounded-full"></span>
                        </button>

                        {/* Flag */}
                        <div className="flex items-center gap-4">
                            <div className="w-8 h-8 rounded-full overflow-hidden bg-gray-200">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg"
                                    alt="USA Flag"
                                    className="w-full h-full object-cover"
                                />
                            </div>
                            {/* Vertical Line */}
                            <div className="border-l h-6 border-gray-300"></div>
                        </div>

                        {/* Profile and Dropdown */}
                        <div className="relative">
                            <button
                                onClick={() => setDropdownOpen(!dropdownOpen)}
                                className="flex items-center space-x-2"
                            >
                                <div className="w-8 h-8 bg-blue-200 text-blue-700 font-bold rounded-full flex items-center justify-center">
                                    A
                                </div>
                                <FaAngleDown className="text-gray-500" />
                                <div className="text-left hidden sm:block text-sm">
                                    <span className="block font-semibold">
                                        {user.name}
                                    </span>
                                    <span className="block text-gray-500 text-xs">
                                        VP People Manager
                                    </span>
                                </div>
                            </button>

                            {dropdownOpen && (
                                <div className="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg">
                                    <div className="flex items-center space-x-4 bg-blue-50 p-4 border-b">
                                        <div className="w-10 h-10 bg-blue-200 text-blue-700 font-bold rounded-full flex items-center justify-center">
                                            A
                                        </div>
                                        <div>
                                            <p className="font-semibold">
                                                {user?.name}
                                            </p>
                                            <p className="text-gray-500 text-xs">
                                                A short profile description
                                            </p>
                                            <p className="text-gray-500 text-xs">
                                                {user?.email}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="mt-4 px-4">
                                        <p className="text-gray-700 text-sm font-semibold mb-2">
                                            MY ACCOUNT
                                        </p>
                                        <ul className="space-y-2">
                                            <li>
                                                <a
                                                    href="/profile"
                                                    className="text-blue-600 hover:underline"
                                                >
                                                    Profile
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    href=""
                                                    className="text-blue-600 hover:underline"
                                                >
                                                    Logs
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <ResponsiveNavLink
                                        method="post"
                                        href={route("logout")}
                                        className=""
                                    >
                                        Logout
                                    </ResponsiveNavLink>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </nav>
            {header && (
                <header className="bg-white shadow">
                    <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {header}
                    </div>
                </header>
            )}
            <main>{children}</main>
        </div>
    );
}
