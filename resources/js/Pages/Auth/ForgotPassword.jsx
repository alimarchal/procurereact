import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { validateForgotPassword } from "@/Components/Validation";
import { useState } from "react";
import InputLabel from "@/Components/InputLabel";

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, reset } = useForm({
        email: "",
    });

    const [errors, setErrors] = useState({});

    const handleInputChange = (e) => {
        const { name, value } = e.target;

        setData((prevFormData) => ({
            ...prevFormData,
            [name]: value,
        }));

        if (value) {
            setErrors((prevErrors) => ({
                ...prevErrors,
                [name]: "",
            }));
        }
    };

    const submit = (e) => {
        e.preventDefault();
        const validationErrors = validateForgotPassword(data);
        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }

        post(route("password.email"), {
            onError: (serverErrors) => {
                setErrors(serverErrors);
            },
            onFinish: () => reset("email"),
        });
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="mb-4 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </div>

            {status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <InputLabel htmlFor="email" value="Email" required={true} />
                <TextInput
                    id="email"
                    type="text"
                    name="email"
                    value={data.email}
                    placeholder="Enter Email Address"
                    className="mt-1 block w-full"
                    onChange={handleInputChange}
                />
                <InputError message={errors.email} />

                <div className="mt-4 flex items-center justify-end">
                    <Link
                        href={route("login")}
                        className="text-sm text-gray-600 underline hover:text-gray-900"
                    >
                        Already registered?
                    </Link>
                    <PrimaryButton className="ms-4" disabled={processing}>
                        {processing
                            ? "Processing..."
                            : "Email Password Reset Link"}
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
