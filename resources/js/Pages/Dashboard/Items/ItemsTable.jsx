import React from "react";

const ItemsTable = ({ items }) => {
    return (
        <div className="bg-white shadow rounded-lg p-4">
            <div className="flex justify-between items-center mb-4">
                <h2 className="text-lg font-semibold">Items</h2>
                <button className="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                    Add New
                </button>
            </div>
            <table className="w-full border-collapse">
                <thead>
                    <tr className="bg-gray-100">
                        <th className="border p-2 text-left">Code</th>
                        <th className="border p-2 text-left">Name</th>
                        <th className="border p-2 text-left">Category</th>
                        <th className="border p-2 text-left">Unit</th>
                        <th className="border p-2 text-left">Stock</th>
                        <th className="border p-2 text-left">Unit Price</th>
                        <th className="border p-2 text-left">Status</th>
                        <th className="border p-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {items.length > 0 ? (
                        items.map((item) => (
                            <tr key={item.id} className="hover:bg-gray-50">
                                <td className="border p-2">{item.code}</td>
                                <td className="border p-2">{item.name}</td>
                                <td className="border p-2">{item.category}</td>
                                <td className="border p-2">{item.unit}</td>
                                <td className="border p-2">{item.stock}</td>
                                <td className="border p-2">{item.unitPrice}</td>
                                <td className="border p-2">{item.status}</td>
                                <td className="border p-2">
                                    <button className="text-blue-500 hover:underline mr-2">
                                        Edit
                                    </button>
                                    <button className="text-red-500 hover:underline">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        ))
                    ) : (
                        <tr>
                            <td
                                className="border p-2 text-center text-gray-500"
                                colSpan="8"
                            >
                                No data available in table
                            </td>
                        </tr>
                    )}
                </tbody>
            </table>
            <div className="flex justify-between items-center mt-4">
                <span className="text-gray-600 text-sm">
                    Showing 0 to 0 of 0 entries
                </span>
                <div className="flex space-x-2">
                    <button className="bg-gray-200 text-gray-600 px-3 py-1 rounded hover:bg-gray-300">
                        Previous
                    </button>
                    <button className="bg-gray-200 text-gray-600 px-3 py-1 rounded hover:bg-gray-300">
                        Next
                    </button>
                </div>
            </div>
        </div>
    );
};

export default ItemsTable;
