import React from "react";

export default function Quotation() {
    const quotationData = {
        company: {
            name: "Knowledge Experts Ltd Co.",
            address: "Riyadh - Dammam Road 2591",
            phone: "0565709548",
            vatNo: "310104680030003",
        },
        company_arabic: {
            name: "شركة خبراء المعرفة المحدودة",
            address: "طريق الرياض - الدمام 2591",
            phone: "0565709548",
            vatNo: "310104680030003",
        },
        customer: {
            name: "Malik Fahad Road, Muhammad Dist",
            mobile: "0596926789",
            vatNo: "310301647400003",
        },
        quotation: {
            number: "KE-023",
            date: "13-12-2024",
            validity: "14 days",
            paymentTerm: "Cash",
        },
        items: [
            {
                code: "WATR NOVA 330MLX40",
                description: "Water NOVA 330MLX40",
                quantity: 2,
                unitPrice: 19.5,
                totalPrice: 39.0,
            },
            {
                code: "Hand Washing Soap",
                description: "Hand Washing Soap, Nilter, 500ML",
                quantity: 5,
                unitPrice: 15,
                totalPrice: 75,
            },
            {
                code: "Kleenex",
                description: "Kleenex, 96 Packs",
                quantity: 2,
                unitPrice: 80,
                totalPrice: 160,
            },
            {
                code: "Maxi Rolls",
                description: "Maxi Rolls, 300M, '6'",
                quantity: 6,
                unitPrice: 20,
                totalPrice: 120,
            },
            {
                code: "Glance Toilet Tissue",
                description: 'Glance Toilet Tissue 6", 6+2 Rolls',
                quantity: 2,
                unitPrice: 80,
                totalPrice: 160,
            },
        ],
        summary: {
            subtotal: 966,
            discount: 0,
            vat: 144.9,
            total: 1110,
        },
    };

    return (
        <div className="bg-white border p-8 shadow-lg max-w-5xl mx-auto my-4">
            {/* Header */}
            <header className="flex justify-between items-center border-b pb-4">
                <div>
                    <h1 className="text-2xl font-bold uppercase">
                        {quotationData.company.name}
                    </h1>
                    <p>{quotationData.company.address}</p>
                    <p>VAT No: {quotationData.company.vatNo}</p>
                    <p>Mobile: {quotationData.company.phone}</p>
                </div>
                <img
                    src="/images/smart-precure-logo.png"
                    alt="Company Logo"
                    className="h-20 object-contain"
                />
                <div>
                    <h1 className="text-2xl font-bold uppercase">
                        {quotationData.company_arabic.name}
                    </h1>
                    <p>{quotationData.company_arabic.address}</p>
                    <p>VAT No: {quotationData.company_arabic.vatNo}</p>
                    <p>Mobile: {quotationData.company_arabic.phone}</p>
                </div>
            </header>

            {/* Quotation Info */}
            <section className="mt-6">
                <div className="p-2 flex justify-center text-center border border-gray-400 rounded-md">
                    <h2 className="text-lg font-semibold">
                        Quotation / عرض سعر
                    </h2>
                </div>
                <div className="grid grid-cols-2 gap-6 mt-4">
                    <div className="bg-gray-100 p-4 rounded">
                        <p>
                            <strong>Customer Name:</strong>{" "}
                            {quotationData.customer.name}
                        </p>
                        <p>
                            <strong>Mobile:</strong>{" "}
                            {quotationData.customer.mobile}
                        </p>
                        <p>
                            <strong>VAT No:</strong>{" "}
                            {quotationData.customer.vatNo}
                        </p>
                    </div>
                    <div className="bg-gray-100 p-4 rounded">
                        <p>
                            <strong>Quotation No:</strong>{" "}
                            {quotationData.quotation.number}
                        </p>
                        <p>
                            <strong>Date:</strong>{" "}
                            {quotationData.quotation.date}
                        </p>
                        <p>
                            <strong>Validity:</strong>{" "}
                            {quotationData.quotation.validity}
                        </p>
                        <p>
                            <strong>Payment Term:</strong>{" "}
                            {quotationData.quotation.paymentTerm}
                        </p>
                    </div>
                </div>
            </section>

            {/* Items Table */}
            <table className="w-full mt-8 border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr className="bg-gray-200 text-left">
                        <th className="border p-3">SN</th>
                        <th className="border p-3">Item Code</th>
                        <th className="border p-3">Description</th>
                        <th className="border p-3 text-center">Qty</th>
                        <th className="border p-3 text-center">Unit Price</th>
                        <th className="border p-3 text-center">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    {quotationData.items.map((item, index) => (
                        <tr key={index} className="text-center">
                            <td className="border p-2">{index + 1}</td>
                            <td className="border p-2 text-left">
                                {item.code}
                            </td>
                            <td className="border p-2 text-left">
                                {item.description}
                            </td>
                            <td className="border p-2">{item.quantity}</td>
                            <td className="border p-2">
                                {item.unitPrice.toFixed(2)}
                            </td>
                            <td className="border p-2">
                                {item.totalPrice.toFixed(2)}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>

            {/* Summary */}
            <section className="mt-8">
                <div className="grid grid-cols-2">
                    <div className="bg-gray-100 p-4 rounded">
                        <p>
                            <strong>Subtotal:</strong>{" "}
                            {quotationData.summary.subtotal} SAR
                        </p>
                        <p>
                            <strong>Discount:</strong>{" "}
                            {quotationData.summary.discount} SAR
                        </p>
                        <p>
                            <strong>VAT:</strong> {quotationData.summary.vat}{" "}
                            SAR
                        </p>
                    </div>
                    <div className="text-right">
                        <p className="text-lg font-bold">
                            Total: {quotationData.summary.total} SAR
                        </p>
                    </div>
                </div>
                <p className="mt-4 text-gray-700">
                    SAR: One Thousand, One Hundred Ten Riyals...
                </p>
            </section>
        </div>
    );
}
