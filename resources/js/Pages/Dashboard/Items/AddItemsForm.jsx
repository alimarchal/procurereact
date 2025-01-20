import React, { useState } from "react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import SelectInput from "@/Components/SelectInput";

const AddItemForm = ({ onItemAdded }) => {
    const [formData, setFormData] = useState({
        code: "",
        name: "",
        category: "",
        unit: "",
        quantity: "",
        unitPrice: "",
        stock: "",
        description: "",
        status: "Active",
    });

    const [errors, setErrors] = useState({});

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData({ ...formData, [name]: value });
    };

    const validateForm = () => {
        let validationErrors = {};
        if (!formData.name) validationErrors.name = "Name is required";
        if (!formData.category)
            validationErrors.category = "Category is required";
        if (!formData.quantity) {
            validationErrors.quantity = "Quantity is required";
        } else if (formData.quantity <= 0) {
            validationErrors.quantity = "Quantity must be greater than 0";
        }
        if (!formData.unit) {
            validationErrors.unit = "Unit is required";
        } else if (formData.unit <= 0) {
            validationErrors.unit = "Unit must be greater than 0";
        }
        if (!formData.unitPrice) {
            validationErrors.unitPrice = "Unit Price is required";
        } else if (formData.unitPrice <= 0) {
            validationErrors.unitPrice = "Unit Price must be greater than 0";
        }
        if (!formData.stock) {
            validationErrors.stock = "Stock is required";
        } else if (formData.stock < 0) {
            validationErrors.stock = "Stock cannot be negative";
        }
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
            onItemAdded(formData);
            setErrors({});
        } catch (error) {
            console.error(error);
            alert("An error occurred while saving the item.");
        }
    };

    return (
        <div className="bg-white shadow rounded-lg p-6">
            <h2 className="text-lg font-semibold mb-6">Add Item</h2>
            <form onSubmit={handleSubmit}>
                <div className="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <InputLabel htmlFor="code" value="Code" />
                        <TextInput
                            id="code"
                            name="code"
                            value={formData.code}
                            placeholder="Enter code"
                            className="mt-1 block w-full"
                            autoComplete="code"
                            onChange={handleInputChange}
                        />
                    </div>
                    <div>
                        <InputLabel
                            htmlFor="name"
                            value="Name"
                            required={true}
                        />
                        <TextInput
                            id="name"
                            name="name"
                            value={formData.name}
                            placeholder="Enter name"
                            className="mt-1 block w-full"
                            autoComplete="name"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.name} />
                    </div>
                </div>
                <div className="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <InputLabel
                            htmlFor="category"
                            value="Category"
                            required={true}
                        />
                        <SelectInput
                            id="category"
                            name="category"
                            value={formData.category}
                            onChange={handleInputChange}
                            placeholder="Category"
                            options={[
                                { value: "category1", label: "Category 1" },
                                { value: "category2", label: "Category 2" },
                            ]}
                        />
                        <InputError message={errors.category} />
                    </div>
                    <div>
                        <InputLabel
                            htmlFor="unit"
                            value="Unit"
                            required={true}
                        />
                        <TextInput
                            id="unit"
                            name="unit"
                            value={formData.unit}
                            placeholder="Unit Pcs"
                            className="mt-1 block w-full"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.unit} />
                    </div>
                    <div>
                        <InputLabel
                            htmlFor="quantity"
                            value="Quantity"
                            required={true}
                        />
                        <TextInput
                            id="quantity"
                            name="quantity"
                            type="number"
                            value={formData.quantity}
                            placeholder="Quantity"
                            className="mt-1 block w-full"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.quantity} />
                    </div>
                    <div>
                        <InputLabel
                            htmlFor="unitPrice"
                            value="Unit Price"
                            required={true}
                        />
                        <TextInput
                            id="unitPrice"
                            name="unitPrice"
                            type="number"
                            value={formData.unitPrice}
                            placeholder="Unit Price"
                            className="mt-1 block w-full"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.unitPrice} />
                    </div>
                    <div>
                        <InputLabel
                            htmlFor="stock"
                            value="Stock"
                            required={true}
                        />
                        <TextInput
                            id="stock"
                            name="stock"
                            type="number"
                            value={formData.stock}
                            placeholder="Stock"
                            className="mt-1 block w-full"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.stock} />
                    </div>
                    <div>
                        <InputLabel htmlFor="status" value="Status" />
                        <SelectInput
                            id="status"
                            name="status"
                            value={formData.status}
                            onChange={handleInputChange}
                            placeholder="Status"
                            options={[
                                { value: "Active", label: "Active" },
                                { value: "Inactive", label: "Inactive" },
                            ]}
                        />
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
                    Save Item
                </button>
            </form>
        </div>
    );
};

export default AddItemForm;
