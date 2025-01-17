import React, { useState } from "react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import SelectInput from "@/Components/SelectInput";

const AddCustomersForm = ({ onCustomerAdded }) => {
    const [formData, setFormData] = useState({
        name: "",
        vat_number: "",
        contact_number: "",
        email: "",
        address: "",
    });

    const [errors, setErrors] = useState({});

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData({ ...formData, [name]: value });
    };

    const validateForm = () => {
        let validationErrors = {};
        if (!formData.name) validationErrors.name = "Name is required";
        if (!formData.vat_number)
            validationErrors.vat_number = "VAT Number is required";
        if (!formData.contact_number)
            validationErrors.contact_number = "Contact Number is required";
        if (!formData.email) {
            validationErrors.email = "Email is required";
        } else if (
            !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(
                formData.email
            )
        ) {
            validationErrors.email = "Please enter a valid email address";
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
            onCustomerAdded(formData);
            setErrors({});
        } catch (error) {
            console.error(error);
            alert("An error occurred while saving the item.");
        }
    };

    return (
        <div className="bg-white shadow rounded-lg p-6">
            <h2 className="text-lg font-semibold mb-6">Add Customers</h2>
            <form onSubmit={handleSubmit}>
                <div className="grid grid-cols-2 gap-4 mb-4">
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
                            placeholder="Enter Name"
                            className="mt-1 block w-full"
                            autoComplete="name"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.name} />
                    </div>
                    <div>
                        <InputLabel
                            htmlFor="vat_number"
                            value="Vat Number"
                            required={true}
                        />
                        <TextInput
                            id="vat_number"
                            name="vat_number"
                            value={formData.vat_number}
                            placeholder="Enter Vat Number"
                            className="mt-1 block w-full"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.vat_number} />
                    </div>
                    <div>
                        <InputLabel
                            htmlFor="contact_number"
                            value="Contact Number"
                            required={true}
                        />
                        <TextInput
                            id="contact_number"
                            name="contact_number"
                            type="text"
                            value={formData.contact_number}
                            placeholder="Enter Contact Number"
                            className="mt-1 block w-full"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.contact_number} />
                    </div>
                    <div>
                        <InputLabel
                            htmlFor="email"
                            value="Email"
                            required={true}
                        />
                        <TextInput
                            id="email"
                            name="email"
                            type="text"
                            value={formData.email}
                            placeholder="Enter Email Address"
                            className="mt-1 block w-full"
                            onChange={handleInputChange}
                        />
                        <InputError message={errors.email} />
                    </div>
                </div>
                <div className="mb-4">
                    <InputLabel htmlFor="address" value="Address" />
                    <textarea
                        id="address"
                        name="address"
                        value={formData.address}
                        placeholder="Enter Address"
                        className="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        rows="4"
                        onChange={handleInputChange}
                    ></textarea>
                </div>
                <button
                    type="submit"
                    className="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 w-full"
                >
                    Save Customer
                </button>
            </form>
        </div>
    );
};

export default AddCustomersForm;
