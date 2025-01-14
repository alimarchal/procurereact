const SelectInput = ({ id, name, value, options, onChange, placeholder }) => {
    return (
        <div>
            <select
                id={id}
                name={name}
                value={value}
                onChange={onChange}
                className="mt-1 p-3 rounded-md shadow-sm focus:border-indigo-500 block w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
                <option value="">{`Select ${placeholder}`}</option>
                {options.map((option, index) => (
                    <option key={index} value={option.value}>
                        {option.label}
                    </option>
                ))}
            </select>
        </div>
    );
};

export default SelectInput;
