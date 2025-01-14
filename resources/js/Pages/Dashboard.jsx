import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { useState } from "react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import SelectInput from "@/Components/SelectInput";
import { validateForm } from "@/Components/Validation";

export default function Dashboard({ auth, company }) {
    const [formData, setFormData] = useState({
        name: "",
        name_arabic: "",
        email: "",
        cr_number: "",
        vat_number: "",
        vat_number_arabic: "",
        cell: "",
        mobile: "",
        phone: "",
        address: "",
        city: "",
        country: "",
        customer_industry: "",
        sale_type: "",
        article_no: "",
        business_type_english: "",
        business_type_arabic: "",
        business_description_english: "",
        business_description_arabic: "",
        invoice_side_english: "",
        invoice_side_arabic: "",
        english_description: "",
        arabic_description: "",
        vat_percentage: "",
        apply_discount_type: "",
        language: "",
        show_email_on_invoice: false,
        website: "",
        company_type: "",
        bank_name: "",
        iban: "",
        company_logo: null,
        company_stamp: null,
    });

    const [errors, setErrors] = useState({});

    const handleInputChange = (e) => {
        const { name, value, type, checked } = e.target;
        const fieldValue = type === "checkbox" ? checked : value;

        setFormData((prevFormData) => ({
            ...prevFormData,
            [name]: fieldValue,
        }));

        if (fieldValue) {
            setErrors((prevErrors) => ({
                ...prevErrors,
                [name]: "",
            }));
        }
    };

    const handleCheckboxChange = (e) => {
        const { name, checked } = e.target;
        setFormData({
            ...formData,
            [name]: checked,
        });
    };

    const handleFileChange = (e) => {
        const { name, files } = e.target;
        setFormData({
            ...formData,
            [name]: files[0],
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const validationErrors = validateForm(formData);

        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }
        console.log("Form Submitted:", formData);
    };

    return (
        <AuthenticatedLayout>
            <div className="py-12">
                {!company ? (
                    <div className="container mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h3 className="text-center text-xl font-bold mb-6">
                                    Please Complete Business Contact Information
                                </h3>
                                <form onSubmit={handleSubmit}>
                                    {/* Basic Information Section */}
                                    <div className="bg-gray-100 p-6 rounded-lg mb-6">
                                        <h4 className="text-lg font-semibold mb-4">
                                            Basic Information
                                        </h4>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <InputLabel
                                                    htmlFor="name"
                                                    value="Company Name (English)"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="name"
                                                    name="name"
                                                    value={formData.name}
                                                    placeholder="Enter Company Name"
                                                    className="mt-1 block w-full"
                                                    autoComplete="name"
                                                    onChange={handleInputChange}
                                                    aria-label="Company Name"
                                                />
                                                <InputError
                                                    message={errors.name}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="name_arabic"
                                                    value="Company Name (Arabic)"
                                                />
                                                <TextInput
                                                    id="name_arabic"
                                                    name="name_arabic"
                                                    value={formData.name_arabic}
                                                    placeholder="Enter Company Arabic Name"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    aria-label="Company Name (Arabic)"
                                                />
                                                <InputError
                                                    message={errors.name_arabic}
                                                />
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
                                                    value={formData.email}
                                                    placeholder="Enter Email Address"
                                                    className="mt-1 block w-full"
                                                    autoComplete="email"
                                                    onChange={handleInputChange}
                                                    aria-label="Email Address"
                                                />
                                                <InputError
                                                    message={errors.email}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="cr_number"
                                                    value="CR Number"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="cr_number"
                                                    name="cr_number"
                                                    value={formData.cr_number}
                                                    placeholder="Enter CR Number"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    aria-label="CR Number"
                                                />
                                                <InputError
                                                    message={errors.cr_number}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="vat_number"
                                                    value="VAT Number (English)"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="vat_number"
                                                    name="vat_number"
                                                    value={formData.vat_number}
                                                    placeholder="Enter VAT Number"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    aria-label="VAT Number (English)"
                                                />
                                                <InputError
                                                    message={errors.vat_number}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="vat_number_arabic"
                                                    value="VAT Number (Arabic)"
                                                />
                                                <TextInput
                                                    id="vat_number_arabic"
                                                    name="vat_number_arabic"
                                                    value={
                                                        formData.vat_number_arabic
                                                    }
                                                    placeholder="Enter VAT Number (Arabic)"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    aria-label="VAT Number (Arabic)"
                                                />
                                                <InputError
                                                    message={
                                                        errors.vat_number_arabic
                                                    }
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    {/* Contact Information Section */}
                                    <div className="bg-gray-100 p-6 rounded-lg mb-6">
                                        <h4 className="text-lg font-semibold mb-4">
                                            Contact Information
                                        </h4>
                                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <InputLabel
                                                    htmlFor="cell"
                                                    value="Cell Phone"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="cell"
                                                    name="cell"
                                                    value={formData.cell}
                                                    placeholder="Enter Cell Phone"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={errors.cell}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="mobile"
                                                    value="Mobile"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="mobile"
                                                    name="mobile"
                                                    value={formData.mobile}
                                                    placeholder="Enter Mobile"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={errors.mobile}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="phone"
                                                    value="Phone"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="phone"
                                                    name="phone"
                                                    value={formData.phone}
                                                    placeholder="Enter Phone"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={errors.phone}
                                                />
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                                            <div className="md:col-span-2">
                                                <InputLabel
                                                    htmlFor="address"
                                                    value="Address"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="address"
                                                    name="address"
                                                    value={formData.address}
                                                    placeholder="Enter Address"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={errors.address}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="city"
                                                    value="City"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="city"
                                                    name="city"
                                                    value={formData.city}
                                                    placeholder="Enter City"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={errors.city}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="country"
                                                    value="Country"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="country"
                                                    name="country"
                                                    value={formData.country}
                                                    placeholder="Enter Country"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={errors.country}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    {/* Business Contact Information Section */}
                                    <div className="bg-gray-100 p-6 rounded-lg mb-6">
                                        <h4 className="text-lg font-semibold mb-4">
                                            Business Contact Information
                                        </h4>
                                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div>
                                                <InputLabel
                                                    htmlFor="customer_industry"
                                                    value="Customer Industry"
                                                    required={true}
                                                />
                                                <SelectInput
                                                    id="customer_industry"
                                                    name="customer_industry"
                                                    value={
                                                        formData.customer_industry
                                                    }
                                                    onChange={handleInputChange}
                                                    placeholder="Industry"
                                                    options={[
                                                        {
                                                            value: "Regular",
                                                            label: "Regular",
                                                        },
                                                        {
                                                            value: "Industrial",
                                                            label: "Industrial",
                                                        },
                                                        {
                                                            value: "Commercial",
                                                            label: "Commercial",
                                                        },
                                                    ]}
                                                />
                                                <InputError
                                                    message={
                                                        errors.customer_industry
                                                    }
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="sale_type"
                                                    value="Sale Type"
                                                    required={true}
                                                />
                                                <SelectInput
                                                    id="sale_type"
                                                    name="sale_type"
                                                    value={formData.sale_type}
                                                    onChange={handleInputChange}
                                                    placeholder="Sale Type"
                                                    options={[
                                                        {
                                                            value: "Manual",
                                                            label: "Manual",
                                                        },
                                                        {
                                                            value: "Automated",
                                                            label: "Automated",
                                                        },
                                                    ]}
                                                />
                                                <InputError
                                                    message={errors.sale_type}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="article_no"
                                                    value="Document Prefix"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="article_no"
                                                    name="article_no"
                                                    value={formData.article_no}
                                                    placeholder="Enter Document Prefix"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={errors.article_no}
                                                />
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                            <div>
                                                <InputLabel
                                                    htmlFor="business_type_english"
                                                    value="Business Type (English)"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="business_type_english"
                                                    name="business_type_english"
                                                    value={
                                                        formData.business_type_english
                                                    }
                                                    placeholder="Enter Business Type (English)"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={
                                                        errors.business_type_english
                                                    }
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="business_type_arabic"
                                                    value="Business Type (Arabic)"
                                                />
                                                <TextInput
                                                    id="business_type_arabic"
                                                    name="business_type_arabic"
                                                    value={
                                                        formData.business_type_arabic
                                                    }
                                                    placeholder="Enter Business Type (Arabic)"
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                />
                                                <InputError
                                                    message={
                                                        errors.business_type_arabic
                                                    }
                                                />
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                            <div>
                                                <InputLabel
                                                    htmlFor="business_description_english"
                                                    value="Business Description (English)"
                                                    required={true}
                                                />
                                                <textarea
                                                    id="business_description_english"
                                                    name="business_description_english"
                                                    value={
                                                        formData.business_description_english
                                                    }
                                                    placeholder="Enter Business Description (English)"
                                                    className="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    rows="3"
                                                    onChange={handleInputChange}
                                                ></textarea>
                                                <InputError
                                                    message={
                                                        errors.business_description_english
                                                    }
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="business_description_arabic"
                                                    value="Business Description (Arabic)"
                                                />
                                                <textarea
                                                    id="business_description_arabic"
                                                    name="business_description_arabic"
                                                    value={
                                                        formData.business_description_arabic
                                                    }
                                                    placeholder="Enter Business Description (Arabic)"
                                                    className="mt-1 block w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    rows="3"
                                                    onChange={handleInputChange}
                                                ></textarea>
                                                <InputError
                                                    message={
                                                        errors.business_description_arabic
                                                    }
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    {/* Invoice Settings Section */}
                                    <div className="bg-gray-100 p-6 rounded-lg mb-6">
                                        <h4 className="text-lg font-semibold mb-4">
                                            Invoice Settings
                                        </h4>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <InputLabel
                                                    htmlFor="invoice_side_english"
                                                    value="Invoice Side (English)"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="invoice_side_english"
                                                    name="invoice_side_english"
                                                    value={
                                                        formData.invoice_side_english
                                                    }
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    placeholder="Invoice Side (English)"
                                                />
                                                <InputError
                                                    message={
                                                        errors.invoice_side_english
                                                    }
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="invoice_side_arabic"
                                                    value="Invoice Side (Arabic)"
                                                />
                                                <TextInput
                                                    id="invoice_side_arabic"
                                                    name="invoice_side_arabic"
                                                    value={
                                                        formData.invoice_side_arabic
                                                    }
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    placeholder="Invoice Side (Arabic)"
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="english_description"
                                                    value="English Description"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="english_description"
                                                    name="english_description"
                                                    value={
                                                        formData.english_description
                                                    }
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    placeholder="English Description"
                                                />
                                                <InputError
                                                    message={
                                                        errors.english_description
                                                    }
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="arabic_description"
                                                    value="Arabic Description"
                                                />
                                                <TextInput
                                                    id="arabic_description"
                                                    name="arabic_description"
                                                    value={
                                                        formData.arabic_description
                                                    }
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    placeholder="Arabic Description"
                                                />
                                            </div>
                                        </div>
                                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                                            <div>
                                                <InputLabel
                                                    htmlFor="vat_percentage"
                                                    value="VAT Percentage"
                                                    required={true}
                                                />
                                                <TextInput
                                                    id="vat_percentage"
                                                    name="vat_percentage"
                                                    value={
                                                        formData.vat_percentage
                                                    }
                                                    className="mt-1 block w-full"
                                                    onChange={handleInputChange}
                                                    placeholder="VAT Percentage"
                                                    type="number"
                                                />
                                                <InputError
                                                    message={
                                                        errors.vat_percentage
                                                    }
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="apply_discount_type"
                                                    value="Discount Type"
                                                    required={true}
                                                />
                                                <SelectInput
                                                    id="apply_discount_type"
                                                    name="apply_discount_type"
                                                    value={
                                                        formData.apply_discount_type
                                                    }
                                                    onChange={handleInputChange}
                                                    placeholder="Discount Type"
                                                    options={[
                                                        {
                                                            value: "Before",
                                                            label: "Before",
                                                        },
                                                        {
                                                            value: "After",
                                                            label: "After",
                                                        },
                                                    ]}
                                                />
                                                <InputError
                                                    message={
                                                        errors.apply_discount_type
                                                    }
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="language"
                                                    value="Language"
                                                    required={true}
                                                />
                                                <SelectInput
                                                    id="language"
                                                    name="language"
                                                    value={formData.language}
                                                    onChange={handleInputChange}
                                                    placeholder="Language"
                                                    options={[
                                                        {
                                                            value: "english",
                                                            label: "English",
                                                        },
                                                        {
                                                            value: "arabic",
                                                            label: "Arabic",
                                                        },
                                                    ]}
                                                />
                                                <InputError
                                                    message={errors.language}
                                                />
                                            </div>
                                        </div>
                                        <div className="my-4">
                                            <div className="form-check">
                                                <input
                                                    type="checkbox"
                                                    className="form-check-input"
                                                    id="show_email_on_invoice"
                                                    name="show_email_on_invoice"
                                                    checked={
                                                        formData.show_email_on_invoice
                                                    }
                                                    onChange={
                                                        handleCheckboxChange
                                                    }
                                                />
                                                <label
                                                    className="ms-2 form-check-label text-sm"
                                                    htmlFor="show_email_on_invoice"
                                                >
                                                    Show Email on Invoice
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    {/* Additional Information Section */}
                                    <div className="bg-gray-100 p-6 rounded-lg mb-6">
                                        <h4 className="text-lg font-semibold mb-4">
                                            Additional Information
                                        </h4>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <InputLabel
                                                    htmlFor="website"
                                                    value="Website"
                                                />
                                                <TextInput
                                                    id="website"
                                                    name="website"
                                                    value={formData.website}
                                                    onChange={handleInputChange}
                                                    className="mt-1 block w-full"
                                                    placeholder="Website"
                                                    type="text"
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="company_type"
                                                    value="Company Type"
                                                />
                                                <SelectInput
                                                    id="company_type"
                                                    name="company_type"
                                                    value={
                                                        formData.company_type
                                                    }
                                                    onChange={handleInputChange}
                                                    placeholder="Company Type"
                                                    options={[
                                                        {
                                                            value: "customer",
                                                            label: "Customer",
                                                        },
                                                        {
                                                            value: "vendor",
                                                            label: "Vendor",
                                                        },
                                                    ]}
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="bank_name"
                                                    value="Bank Name"
                                                />
                                                <TextInput
                                                    id="bank_name"
                                                    name="bank_name"
                                                    value={formData.bank_name}
                                                    onChange={handleInputChange}
                                                    className="mt-1 block w-full"
                                                    placeholder="Bank Name"
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="iban"
                                                    value="IBAN"
                                                />
                                                <TextInput
                                                    id="iban"
                                                    name="iban"
                                                    value={formData.iban}
                                                    onChange={handleInputChange}
                                                    className="mt-1 block w-full"
                                                    placeholder="IBAN"
                                                    maxLength="50"
                                                />
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="company_logo"
                                                    value="Company Logo"
                                                />
                                                <div className="input-group">
                                                    <input
                                                        type="file"
                                                        className="form-control mt-1 block w-full p-3 rounded-md bg-white border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        id="company_logo"
                                                        name="company_logo"
                                                        accept="image/*"
                                                        onChange={
                                                            handleFileChange
                                                        }
                                                    />
                                                </div>
                                                <small className="form-text text-muted">
                                                    Accepted formats: PNG, JPG,
                                                    JPEG, GIF, WEBP (Max 5MB)
                                                </small>
                                            </div>
                                            <div>
                                                <InputLabel
                                                    htmlFor="company_stamp"
                                                    value="Company Stamp"
                                                />
                                                <div className="input-group">
                                                    <input
                                                        type="file"
                                                        className="form-control mt-1 block w-full p-3 rounded-md bg-white border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        id="company_stamp"
                                                        name="company_stamp"
                                                        accept="image/*"
                                                        onChange={
                                                            handleFileChange
                                                        }
                                                    />
                                                </div>
                                                <small className="form-text text-muted">
                                                    Accepted formats: PNG, JPG,
                                                    JPEG, GIF, WEBP (Max 5MB)
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="text-center">
                                        <button
                                            type="submit"
                                            className="px-6 py-3 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600"
                                        >
                                            Submit Registration
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                ) : (
                    <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div className="bg-white shadow-sm sm:rounded-lg">
                            <div className="p-6">
                                <h4 className="text-xl font-semibold mb-4">
                                    Welcome to the Dashboard
                                </h4>
                                <p>Here is your main dashboard content.</p>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
