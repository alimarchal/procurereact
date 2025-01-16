import React, { useState } from "react";
import CategoriesTable from "./CategoriesTable";
import AddCategoryForm from "./AddCategoryForm";

const Category = () => {
    const [isAdding, setIsAdding] = useState(false);
    const [categories, setCategories] = useState([]);

    // const fetchCategories = async () => {
    //     const response = await fetch("/api/categories");
    //     const data = await response.json();
    //     setCategories(data);
    // };

    const handleCategoryAdded = (newCategory) => {
        setCategories([...categories, newCategory]);
        setIsAdding(false);
    };

    // React.useEffect(() => {
    //     fetchCategories();
    // }, []);

    return (
        <div>
            <div className="flex space-x-4 my-6">
                <button
                    className={`px-4 py-2 rounded ${
                        !isAdding
                            ? "bg-blue-500 text-white"
                            : "bg-gray-200 text-gray-600"
                    }`}
                    onClick={() => setIsAdding(false)}
                >
                    Categories
                </button>
                <button
                    className={`px-4 py-2 rounded ${
                        isAdding
                            ? "bg-blue-500 text-white"
                            : "bg-gray-200 text-gray-600"
                    }`}
                    onClick={() => setIsAdding(true)}
                >
                    Add New
                </button>
            </div>
            {isAdding ? (
                <AddCategoryForm onCategoryAdded={handleCategoryAdded} />
            ) : (
                <CategoriesTable categories={categories} />
            )}
        </div>
    );
};

export default Category;
