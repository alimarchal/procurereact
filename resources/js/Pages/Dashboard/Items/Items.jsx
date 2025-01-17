import React, { useState } from "react";
import ItemsTable from "./ItemsTable";
import AddItemForm from "./AddItemsForm";

const Category = () => {
    const [isAdding, setIsAdding] = useState(false);
    const [items, setItems] = useState([]);

    // const fetchItems = async () => {
    //     const response = await fetch("/api/items");
    //     const data = await response.json();
    //     setItems(data);
    // };

    const handleItemsAdded = (newItem) => {
        setItems([...items, newItem]);
        setIsAdding(false);
    };

    // React.useEffect(() => {
    //     fetchItems();
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
                    Items
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
                <AddItemForm onItemAdded={handleItemsAdded} />
            ) : (
                <ItemsTable items={items} />
            )}
        </div>
    );
};

export default Category;
