import React, { useState } from "react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import axios from "axios";

const AddCategoryForm = ({ onCategoryAdded }) => {
    const [formData, setFormData] = useState({
        name: "",
        status: "",
        description: "",
    });

    const [errors, setErrors] = useState({});

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData({ ...formData, [name]: value });
    };

    const validateForm = () => {
        let validationErrors = {};
        if (!formData.name) validationErrors.name = "Category Name is required";
        return validationErrors;
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        const validationErrors = validateForm();
        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }

        try {
            const token = localStorage.getItem("authToken");

            const config = {
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            };

            const response = await axios.post(
                "/api/categories",
                formData,
                config
            );

            setFormData({ name: "", status: "", description: "" });
            setErrors({});
            onCategoryAdded(response.data);
        } catch (error) {
            setErrors(error.response?.data?.errors || {});
            console.error("Error saving category:", error);
        }
    };

    return (
        <div className="bg-white shadow rounded-lg p-4">
            <h2 className="text-lg font-semibold mb-4">Add Category</h2>
            <form onSubmit={handleSubmit}>
                <div className="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <InputLabel
                            htmlFor="name"
                            value="Category Name"
                            required={true}
                        />
                        <TextInput
                            id="name"
                            name="name"
                            value={formData.name}
                            placeholder="Enter category name"
                            className="mt-1 block w-full"
                            autoComplete="name"
                            onChange={handleInputChange}
                            aria-label="Category Name"
                        />
                        <InputError message={errors.name} />
                    </div>
                    <div>
                        <InputLabel htmlFor="status" value="Status" />
                        <select
                            id="status"
                            name="status"
                            value={formData.status}
                            onChange={handleInputChange}
                            placeholder="Status"
                            className="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div className="mb-4">
                    <InputLabel htmlFor="description" value="Description" />
                    <textarea
                        id="description"
                        name="description"
                        value={formData.description}
                        placeholder="Enter description"
                        className="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        rows="4"
                        onChange={handleInputChange}
                    ></textarea>
                </div>
                <button
                    type="submit"
                    className="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 w-full"
                >
                    Save Category
                </button>
            </form>
        </div>
    );
};

export default AddCategoryForm;
