import GuestLayout from "@/Layouts/GuestLayout";

export default function MigoyTest( {...props} ) {
    return (
        <GuestLayout>
            Migoy test hello world hello {props.endpoint} tables {props.tables}
        </GuestLayout>
    );
}
