import React from "react";

const CategoriesTable = ({ categories }) => {
    return (
        <div className="bg-white shadow rounded-lg p-4">
            <h2 className="text-lg font-semibold mb-4">Categories</h2>
            <table className="w-full border-collapse">
                <thead>
                    <tr className="bg-gray-100">
                        <th className="border p-2 text-left">Name</th>
                        <th className="border p-2 text-left">Description</th>
                        <th className="border p-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {categories.map((category) => (
                        <tr key={category.id}>
                            <td className="border p-2">{category.name}</td>
                            <td className="border p-2">
                                {category.description}
                            </td>
                            <td className="border p-2">{category.status}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default CategoriesTable;
