// Login Form validation
export const validateLogin = (data) => {
    const errors = {};
    if (!data.email) errors.email = "Email is required";
    if (!data.password) errors.password = "Password is required";
    return errors;
};

// Forgot Password Form validation
export const validateForgotPassword = (data) => {
    const errors = {};
    if (!data.email) {
        errors.email = "Email is required";
    } else if (
        !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(data.email)
    ) {
        errors.email = "Invalid email format";
    }
    return errors;
};

// Register Form validation
export const validateRegister = (data) => {
    const errors = {};

    if (!data.name) errors.name = "Full Name is required";
    if (!data.email) {
        errors.email = "Email is required";
    } else if (
        !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(data.email)
    ) {
        errors.email = "Invalid email format";
    }
    if (!data.password) {
        errors.password = "Password is required";
    }

    if (!data.password_confirmation) {
        errors.password_confirmation = "Confirm Password is required";
    } else if (data.password !== data.password_confirmation) {
        errors.password_confirmation = "Passwords do not match";
    }

    return errors;
};

// Dashboard validation
export const validateForm = (formData) => {
    const errors = {};

    // Business Information validation
    if (!formData.name) errors.name = "Company Name (English) is required";
    if (!formData.email) {
        errors.email = "Email is required";
    } else if (
        !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(formData.email)
    ) {
        errors.email = "Please enter a valid email address";
    }
    if (!formData.cr_number) errors.cr_number = "CR Number is required";
    if (!formData.vat_number)
        errors.vat_number = "VAT Number (English) is required";

    // Contact Informatio validation
    if (!formData.cell) errors.cell = "Cell Phone is required";
    if (!formData.mobile) errors.mobile = "Mobile is required";
    if (!formData.phone) errors.phone = "Phone is required";
    if (!formData.address) errors.address = "Address is required";
    if (!formData.city) errors.city = "City is required";
    if (!formData.country) errors.country = "Country is required";

    // Business Contact Information validation
    if (!formData.customer_industry)
        errors.customer_industry = "Customer Industry is required";
    if (!formData.sale_type) errors.sale_type = "Sale Type is required";
    if (!formData.article_no) errors.article_no = "Document Prefix is required";
    if (!formData.business_type_english)
        errors.business_type_english = "Business Type (English) is required";
    if (!formData.business_description_english)
        errors.business_description_english =
            "Business Description (English) is required";

    // Invoice Settings validation
    if (!formData.invoice_side_english)
        errors.invoice_side_english = "Invoice Side (English) is required";
    if (!formData.english_description)
        errors.english_description = "English Description is required";
    if (!formData.vat_percentage)
        errors.vat_percentage = "VAT Percentage is required";
    if (!formData.apply_discount_type)
        errors.apply_discount_type = "Discount Type is required";
    if (!formData.language) errors.language = "Language is required";

    // Additional validation
    if (!formData.company_type)
        errors.company_type = "Company Type is required";
    
    return errors;
};
