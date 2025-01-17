import React, { useState } from "react";
import CustomersTable from "./CustomersTable";
import AddCustomersForm from "./AddCustomersForm";

const Customer = () => {
    const [isAdding, setIsAdding] = useState(false);
    const [customers, setCustomers] = useState([]);

    // const fetchCustomers = async () => {
    //     const response = await fetch("/api/customers");
    //     const data = await response.json();
    //     setCustomers(data);
    // };

    const handleCustomerAdded = (newCustomer) => {
        setCustomers([...customers, newCustomer]);
        setIsAdding(false);
    };

    // React.useEffect(() => {
    //     fetchCustomers();
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
                    Customers (Buyers)
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
                <AddCustomersForm onCustomerAdded={handleCustomerAdded} />
            ) : (
                <CustomersTable customers={customers} />
            )}
        </div>
    );
};

export default Customer;
