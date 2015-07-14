class FileSystemError(Exception):
    pass


class NodeDoesNotExistError(FileSystemError):
    pass


class SourceNodeDoesNotExistError(NodeDoesNotExistError, FileSystemError):
    pass


class DestinationNodeDoesNotExistError(NodeDoesNotExistError, FileSystemError):
    pass


class FileSystemMountError(FileSystemError):
    pass


class MountPointDoesNotExistError(FileSystemMountError, FileSystemError):
    pass


class MountPointNotADirectoryError(FileSystemMountError, FileSystemError):
    pass


class MountPointNotEmptyError(FileSystemMountError, FileSystemError):
    pass


class NotAMountpointError(FileSystemMountError, FileSystemError):
    pass


class NotEnoughSpaceError(FileSystemError):
    pass


class NonExplicitDirectoryDeletionError(FileSystemError):
    pass


class NonEmptyDirectoryDeletionError(FileSystemError):
    pass


class DestinationNotADirectoryError(FileSystemError):
    pass


class DestinationNodeExistsError(FileSystemError):
    pass


class File:

    def __init__(self, name, content):
        self.content = content
        self.is_directory = False
        self.name = name
        self.size = len(content) + 1

    def append(self, text):
        self.content += text
        self.size += len(text)

    def truncate(self, text):
        self.content = text
        self.size = len(text)

    def remove(self, filesystem):
        filesystem.available_size += self.size


class Directory:

    def __init__(self, name):
        self.directories = []
        self.files = []
        self.nodes = []
        self.name = name
        self.is_directory = True
        self.is_root = False

    def add_file(self, file_to_add):
        self.files.append(file_to_add)
        self.nodes.append(file_to_add)

    def add_directory(self, directory):
        self.directories.append(directory)
        self.nodes.append(directory)

    def remove(self, filesystem):
        filesystem.available_size += 1
        for node in self.nodes:
            node.remove(filesystem)


class FileSystem:

    def __init__(self, size):
        self.size = size
        self.available_size = size - 1
        self.root = Directory("")
        self.root.is_root = True

    def get_node(self, path):
        if path == "":
            return self.root
        path = path.split('/')
        if path[1] == "":
            return self.root
        current_dir = self.root
        for directory in path[1:-1]:
            is_directory_found = False
            for dirr in current_dir.directories:
                if directory == dirr.name:
                    is_directory_found = True
                    current_dir = dirr
            if not is_directory_found:
                raise NodeDoesNotExistError
        for node in current_dir.nodes:
            if node.name == path[-1]:
                return node
        raise NodeDoesNotExistError

    def create(self, path, directory=False, content=''):
        if self.available_size - len(content) - 1 < 0:
            raise NotEnoughSpaceError
        path, node_name = path.rsplit('/', 1)

        if path == '':
            father_node = self.root
        else:
            try:
                father_node = self.get_node(path)
            except (NodeDoesNotExistError):
                raise DestinationNodeDoesNotExistError
        if father_node.is_directory is False:
            raise DestinationNodeDoesNotExistError
        for node in father_node.nodes:
            if node.name == node_name:
                raise DestinationNodeExistsError

        self.available_size = self.available_size - len(content) - 1
        if directory:
            new_directory = Directory(node_name)
            father_node.add_directory(new_directory)
        else:
            new_file = File(node_name, content)
            father_node.add_file(new_file)

    def remove(self, path, directory=False, force=True):
        path, node_name = path.rsplit('/', 1)

        if path == '':
            father_node = self.root
        else:
            try:
                father_node = self.get_node(path)
            except (NodeDoesNotExistError):
                raise NodeDoesNotExistError
        node_to_delete = None
        for node in father_node.nodes:
            if node.name == node_name:
                node_to_delete = node
        if node_to_delete is None:
            raise NodeDoesNotExistError

        if node_to_delete.is_directory and directory is False:
            raise NonExplicitDirectoryDeletionError
        if (node_to_delete.is_directory and len(node_to_delete.nodes) > 0
                and force is False):
            raise NonEmptyDirectoryDeletionError

        if node_to_delete.is_directory:
            node_to_delete.remove(self)
            father_node.nodes.remove(node_to_delete)
            father_node.directories.remove(node_to_delete)
        else:
            node_to_delete.remove(self)
            father_node.nodes.remove(node_to_delete)
            father_node.files.remove(node_to_delete)

    def mount(self, file_system, path):
        try:
            mount_node = self.get_node(path)
        except (NodeDoesNotExistError):
            raise MountPointDoesNotExistError

        if mount_node.is_directory is False:
            raise MountPointNotEmptyError
        if len(mount_node.nodes) > 0:
            raise MountPointNotEmptyError

        father_node = self.get_node(path.rsplit('/', 1)[0])
        father_node.nodes.remove(mount_node)
        father_node.directories.remove(mount_node)
        file_system.root.name = mount_node.name
        father_node.nodes.append(file_system.root)
        father_node.directories.append(file_system.root)

    def unmount(self, path):
        try:
            unmount_node = self.get_node(path)
        except (NodeDoesNotExistError):
            raise NodeDoesNotExistError

        if unmount_node.is_root is False:
            raise NotAMountpointError

        father_node = self.get_node(path.rsplit('/', 1)[0])
        father_node.nodes.remove(unmount_node)
        father_node.directories.remove(unmount_node)
        regular_directory = Directory(unmount_node.name)
        father_node.nodes.append(regular_directory)
        father_node.directories.append(regular_directory)

    def move(self, source, destination):
        try:
            source_node = self.get_node(source)
        except (NodeDoesNotExistError):
            raise SourceNodeDoesNotExistError

        try:
            destination_node = self.get_node(destination)
        except (NodeDoesNotExistError):
            raise DestinationNodeDoesNotExistError

        if destination_node.is_directory is False:
            raise DestinationNotADirectoryError
        for node in destination_node.nodes:
            if node.name == source_node.name:
                raise DestinationNodeExistsError

        father_node = self.get_node(source.rsplit('/', 1)[0])
        father_node.nodes.remove(source_node)
        destination_node.nodes.append(source_node)
        if source_node.is_directory:
            father_node.directories.remove(source_node)
            destination_node.directories.append(source_node)
        else:
            father_node.files.remove(source_node)
            destination_node.files.append(source_node)
