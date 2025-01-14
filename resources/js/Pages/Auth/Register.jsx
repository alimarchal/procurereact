import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { validateRegister } from "@/Components/Validation";
import { useState } from "react";

export default function Register() {
    const { data, setData, post, processing, reset } = useForm({
        name: "",
        email: "",
        ibr_no: "",
        password: "",
        password_confirmation: "",
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
        const validationErrors = validateRegister(data);

        if (Object.keys(validationErrors).length > 0) {
            setErrors(validationErrors);
            return;
        }
        post(route("register"), {
            onError: (serverErrors) => {
                setErrors(serverErrors);
            },
            onFinish: () => reset("password", "password_confirmation"),
        });
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            <form onSubmit={submit} className="space-y-4">
                <div>
                    <InputLabel
                        htmlFor="ibr_no"
                        value="Reference No."
                        required={false}
                    />
                    <TextInput
                        id="ibr_no"
                        name="ibr_no"
                        value={data.ibr_no}
                        placeholder="Enter Reference No, If any"
                        className="mt-1 block w-full"
                        autoComplete="off"
                        onChange={handleInputChange}
                        aria-label="Reference Number"
                    />
                </div>
                <div>
                    <InputLabel htmlFor="name" value="Name" required={true} />
                    <TextInput
                        id="name"
                        name="name"
                        value={data.name}
                        placeholder="Enter Full Name"
                        className="mt-1 block w-full"
                        autoComplete="name"
                        onChange={handleInputChange}
                        aria-label="Full name"
                    />
                    <InputError message={errors.name} />
                </div>
                <div>
                    <InputLabel htmlFor="email" value="Email" required={true} />
                    <TextInput
                        id="email"
                        name="email"
                        value={data.email}
                        placeholder="Enter Email"
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={handleInputChange}
                        aria-label="Email address"
                    />
                    <InputError message={errors.email} />
                </div>
                <div>
                    <InputLabel
                        htmlFor="password"
                        value="Password"
                        required={true}
                    />
                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        placeholder="Enter Password"
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={handleInputChange}
                        aria-label="Password"
                    />
                    <InputError message={errors.password} />
                </div>
                <div>
                    <InputLabel
                        htmlFor="password_confirmation"
                        value="Confirm Password"
                        required={true}
                    />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        placeholder="Enter Confirm Password"
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={handleInputChange}
                        aria-label="Confirm password"
                    />
                    <InputError message={errors.password_confirmation} />
                </div>
                <div className="flex items-center justify-between space-y-4">
                    <Link
                        href={route("login")}
                        className="text-sm text-gray-600 underline hover:text-gray-900"
                    >
                        Already registered?
                    </Link>
                    <PrimaryButton className="ml-4" disabled={processing}>
                        {processing ? "Processing..." : "Register"}
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
