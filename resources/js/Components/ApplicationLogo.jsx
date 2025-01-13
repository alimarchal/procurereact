const ApplicationLogo = ({ src, alt, className }) => {
    return <img src={src} alt={alt} className={`h-24 w-auto ${className}`} />;
};

export default ApplicationLogo;
